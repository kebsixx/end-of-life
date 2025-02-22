<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default technician credentials:
        // Username: technician
        // Email: technician@example.com
        // Password: techpassword123
        
        User::create([
            'name' => 'Teknisi',
            'username' => 'technician',
            'email' => 'technician@example.com',
            'password' => Hash::make('techpassword123'),
        ]);

        // Test user for development
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
