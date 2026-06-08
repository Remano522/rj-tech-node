<?php

namespace Tests\Feature;

use App\Models\Cv;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_project(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('projects.store'), [
            'title' => 'Sistem Monitoring Router',
            'creator' => 'Remano & Jonathan',
            'category' => 'Network Engineering',
            'description' => 'Platform monitoring router dengan dashboard status perangkat dan statistik jaringan real-time.',
        ])->assertRedirect();

        $project = Project::first();

        $this->assertNotNull($project);
        $this->assertDatabaseHas('projects', [
            'title' => 'Sistem Monitoring Router',
            'creator' => 'Remano & Jonathan',
        ]);

        $this->actingAs($admin)->put(route('projects.update', $project), [
            'title' => 'Sistem Monitoring Router Terintegrasi',
            'creator' => 'Jonathan Christopher S. D.',
            'category' => 'IoT & Monitoring',
            'description' => 'Versi update dengan integrasi sensor, pencatatan data, dan notifikasi kondisi perangkat.',
        ])->assertRedirect();

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Sistem Monitoring Router Terintegrasi',
            'category' => 'IoT & Monitoring',
        ]);

        $this->actingAs($admin)->delete(route('projects.destroy', $project))
            ->assertRedirect();

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_admin_can_update_cv_data(): void
    {
        $admin = User::factory()->admin()->create();
        $cv = Cv::create([
            'slug' => 'tester',
            'name' => 'Tester Admin',
            'photo' => 'foto-tester.jpg',
            'role' => 'Initial Role',
            'bio' => 'Bio awal yang cukup panjang untuk memenuhi validasi sebelum proses update berlangsung.',
            'education' => 'Politeknik Negeri Jakarta',
            'skills' => ['HTML'],
            'experience' => ['Pengalaman awal'],
            'certifications' => ['Sertifikasi awal'],
        ]);

        $this->actingAs($admin)->put(route('cv.update', $cv), [
            'role' => 'Full Stack Developer',
            'bio' => 'Mahasiswa yang fokus pada pengembangan web, integrasi database, dan implementasi antarmuka yang interaktif.',
            'education' => 'Politeknik Negeri Jakarta - Broadband Multimedia',
            'skills' => 'Laravel, JavaScript, MySQL',
            'experience' => "Magang web developer\nAsisten laboratorium",
            'certifications' => "Laravel Basics\nSQL Fundamentals",
            'remove_photo' => '1',
        ])->assertRedirect();

        $cv->refresh();

        $this->assertSame('Full Stack Developer', $cv->role);
        $this->assertNull($cv->photo);
        $this->assertSame(['Laravel', 'JavaScript', 'MySQL'], $cv->skills);
        $this->assertSame(['Magang web developer', 'Asisten laboratorium'], $cv->experience);
    }
}
