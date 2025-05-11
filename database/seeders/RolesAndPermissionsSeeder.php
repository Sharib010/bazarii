<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Optional: Clear cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $roles = ['super admin', 'seller', 'customer'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create users and assign roles
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('123456'),
                'role' => 'super admin',
            ],
            [
                'name' => 'Seller',
                'email' => 'seller@example.com',
                'password' => Hash::make('123456'),
                'role' => 'seller',
            ],
            [
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('123456'),
                'role' => 'customer',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'password' => $data['password']]
            );
            $user->assignRole($data['role']);
        }
    }
}
