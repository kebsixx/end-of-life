<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions first
        Permission::create(['name' => 'manage.all']);
        Permission::create(['name' => 'view.end-of-life']);
        Permission::create(['name' => 'view.widget.stats']);
        Permission::create(['name' => 'view.dashboard']);

        // Create roles
        $technicianRole = Role::create(['name' => 'technician']);
        $userRole = Role::create(['name' => 'user']);

        // Assign permissions to roles
        $technicianRole->givePermissionTo([
            'manage.all',
            'view.end-of-life',
            'view.widget.stats',
            'view.dashboard'
        ]);

        $userRole->givePermissionTo([
            'view.end-of-life'
        ]);

        // Create users with roles
        $technician = User::create([
            'name' => 'Teknisi',
            'username' => 'technician',
            'email' => 'technician@example.com',
            'password' => Hash::make('password'),
        ]);
        $technician->assignRole('technician');

        $user = User::create([
            'name' => 'User',
            'username' => 'useruser',
            'email' => 'user@example.com',
            'password' => Hash::make('userpassword'),
        ]);
        $user->assignRole('user');

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
