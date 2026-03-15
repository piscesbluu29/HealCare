<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
public function run(): void
{
    // Buat User Admin otomatis
    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('password'),
        'role' => 'admin'
    ]);

    // Jalankan Seeder WHO otomatis
    $this->call(WhoStandardSeeder::class);
}
}
