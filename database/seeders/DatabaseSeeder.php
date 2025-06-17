<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $now = now();
$user = [
    [
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'),
        'role' => 'admin',
        'created_at' => $now,
        'updated_at' => $now,
    ],
    [
        'name' => 'Adnan',
        'email' => 'adnan@gmail.com',
        'password' => bcrypt('adnan'),
        'role' => 'mahasiswa',
        'created_at' => $now,
        'updated_at' => $now,
    ],
    [
        'name' => 'Pradana',
        'email' => 'pradana@gmail.com',
        'password' => bcrypt('pradana'),
        'role' => 'mahasiswa',
        'created_at' => $now,
        'updated_at' => $now,
    ],
];

User::insert($user);

    }
}
