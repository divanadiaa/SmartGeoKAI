<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'full_name' => 'Administrator SmartGeoKAI',
                'nip' => '123456789',
                'password' => 'admin123',
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        User::updateOrCreate(
            ['username' => 'petugas1'],
            [
                'full_name' => 'Petugas Lapangan 1',
                'nip' => '987654321',
                'password' => 'petugas123',
                'role' => 'petugas',
                'is_active' => true,
            ]
        );
    }
}