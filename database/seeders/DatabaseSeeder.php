
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'musa@example.com'],
            [
                'name' => 'Musa',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'iman@example.com'],
            [
                'name' => 'Iman',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
            ]
        );

        User::updateOrCreate(
            ['email' => 'kartika@example.com'],
            [
                'name' => 'Kartika',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
            ]
        );

        // Menambahkan data produk
        $this->call([
            ProductSeeder::class,
        ]);
    }
}