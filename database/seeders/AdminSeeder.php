<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // WAJIB ADA INI NGAB BIAR GAK ERROR

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Ridho Pangestu',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'), // Passwordnya: admin123
            'role' => 'admin',
        ]);
    }
}