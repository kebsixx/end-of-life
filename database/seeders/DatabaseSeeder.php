<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Version;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default technician credentials:
        // Username: technician
        // Email: technician@example.com
        // Password: password

        User::create([
            'name' => 'Teknisi',
            'username' => 'technician',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
        ]);

        // Test user for development
        User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Categories Seed
        $categories = [
            [
                'product_name' => 'Windows 11',
                'status' => 'aktif',
                'description' => 'Operating System Windows 11',
            ],
            [
                'product_name' => 'Microsoft Office',
                'status' => 'aktif',
                'description' => 'Microsoft Office Suite',
            ],
            [
                'product_name' => 'Antivirus Pro',
                'status' => 'aktif',
                'description' => 'Security Software',
            ],
            [
                'product_name' => 'Database Server',
                'status' => 'aktif',
                'description' => 'Database Management System',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
