<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Musa',
            'email' => 'musa@example.com',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Kartika',
            'email' => 'kartika@example.com',
            'password' => 'password123',
            'role' => 'mahasiswa',
        ]);

        User::create([
            'name' => 'Iman',
            'email' => 'iman@example.com',
            'password' => 'password123',
            'role' => 'dosen',
        ]);
    }
}