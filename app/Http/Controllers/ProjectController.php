<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateCvRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Cv;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProjectController extends Controller
{
    public function dashboard()
    {
        $projects = Project::latest()->get();
        $cvs = Cv::orderBy('name')->get();

        return view('admin.dashboard', compact('projects', 'cvs'));
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validatedData['image'] = $this->storeImage($request);
        }

        Project::create($validatedData);

        return redirect()->back()->with('success', 'Proyek berhasil ditambahkan!');
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->deleteImage($project->image);
            $validatedData['image'] = $this->storeImage($request);
        }

        $project->update($validatedData);

        return redirect()->back()->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteImage($project->image);
        $project->delete();

        return redirect()->back()->with('success', 'Proyek berhasil dihapus!');
    }

    public function uploadPhoto(Request $request, Project $project): RedirectResponse
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048']);

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $this->deleteImage($project->image);
            $project->image = $this->storeImage($request);
            $project->save();
        }

        return redirect()->back()->with('success', 'Foto proyek berhasil ditambahkan!');
    }

    public function removePhoto(Project $project): RedirectResponse
    {
        $this->deleteImage($project->image);
        $project->image = null;
        $project->save();

        return redirect()->back()->with('success', 'Foto proyek berhasil dihapus!');
    }

    public function updateCv(UpdateCvRequest $request, Cv $cv): RedirectResponse
    {
        $validatedData = $request->validated();

        if ($request->boolean('remove_photo')) {
            $this->deleteImage($cv->photo);
            $cv->photo = null;
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $this->deleteImage($cv->photo);
            $cv->photo = $this->storeUploadedFile($request->file('photo'));
        }

        $cv->role = $validatedData['role'];
        $cv->bio = $validatedData['bio'];
        $cv->education = $validatedData['education'];
        $cv->skills = $this->parseCommaSeparatedInput($validatedData['skills'] ?? null);
        $cv->experience = $this->parseMultilineInput($validatedData['experience'] ?? null);
        $cv->certifications = $this->parseMultilineInput($validatedData['certifications'] ?? null);
        $cv->save();

        return redirect()->back()->with('success', 'CV ' . $cv->name . ' berhasil diperbarui!');
    }

    private function storeImage(Request $request): string
    {
        return $this->storeUploadedFile($request->file('image'));
    }

    private function storeUploadedFile(\Illuminate\Http\UploadedFile $file): string
    {
        File::ensureDirectoryExists(public_path('uploads'));

        $imageName = time() . '_' . uniqid() . '.' . $file->extension();
        $file->move(public_path('uploads'), $imageName);

        return $imageName;
    }

    private function deleteImage(?string $imageName): void
    {
        if (! $imageName) {
            return;
        }

        $imagePath = public_path('uploads/' . $imageName);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }
    }

    private function parseCommaSeparatedInput(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(explode(',', $value))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }

    private function parseMultilineInput(?string $value): array
    {
        if (! $value) {
            return [];
        }

        return collect(explode("\n", str_replace("\r", '', $value)))
            ->map(fn (string $item) => trim($item))
            ->filter()
            ->values()
            ->all();
    }
}
