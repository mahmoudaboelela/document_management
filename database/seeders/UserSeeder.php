<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'email' => 'admin@test.com',
            'password' => Hash::make('12345678'),
            'name' => 'Admin',
        ]);
        $admin->assignRole('Admin');
        $user = User::create([
            'email' => 'user@test.com',
            'password' => Hash::make('12345678'),
            'name' => 'User',
        ]);
        $user->assignRole('User');
        $viewer = User::create([
            'email' => 'viewer@test.com',
            'password' => Hash::make('12345678'),
            'name' => 'Viewer',
        ]);
        $viewer->assignRole('Viewer');
    }
}
