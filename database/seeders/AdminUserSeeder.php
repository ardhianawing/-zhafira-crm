<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'username' => 'admin',
            'password' => 'admin123',
            'nama_lengkap' => 'Administrator',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create marketing users
        User::create([
            'username' => 'marketing1',
            'password' => 'marketing123',
            'nama_lengkap' => 'Andi Wijaya',
            'role' => 'marketing',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'marketing2',
            'password' => 'marketing123',
            'nama_lengkap' => 'Budi Santoso',
            'role' => 'marketing',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'marketing3',
            'password' => 'marketing123',
            'nama_lengkap' => 'Citra Dewi',
            'role' => 'marketing',
            'is_active' => true,
        ]);
    }
}
