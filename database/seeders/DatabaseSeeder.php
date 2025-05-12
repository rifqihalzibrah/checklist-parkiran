<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $roles = [
            'superadmin',
            'chief',
            'supervisor',
            'admin',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Create Users and assign roles
        $users = [
            [
                'name' => 'super_admin',
                'email' => 'superadmin@xyz.com',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
            ],
            [
                'name' => 'chief_1',
                'email' => 'chief1@xyz.com',
                'password' => Hash::make('password'),
                'role' => 'chief',
            ],
            [
                'name' => 'supervisor_1',
                'email' => 'supervisor1@xyz.com',
                'password' => Hash::make('password'),
                'role' => 'supervisor',
            ],
            [
                'name' => 'admin_1',
                'email' => 'admin1@xyz.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                ]
            );

            $user->assignRole($userData['role']);
        }
    }
}
