<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'admin@rjtech.com',
        ], [
            'name' => 'Admin RJ',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
        ]);
    }
}
