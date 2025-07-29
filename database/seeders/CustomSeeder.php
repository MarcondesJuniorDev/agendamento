<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomSeeder extends Seeder
{
    public function run(): void
    {
        // Permissões básicas
        $permissions = [
            'access_admin',
            'create_users',
            'update_users',
            'delete_users',
            'read_users',
            'create_roles',
            'update_roles',
            'delete_roles',
            'read_roles',
            'create_permissions',
            'update_permissions',
            'delete_permissions',
            'read_permissions',
            'change_password', // Permissão para mudar a senha
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Papéis básicos
        $roles = [
            'admin' => [
                'access_admin',
                'create_users',
                'read_users',
                'update_users',
                'delete_users',
                'create_roles',
                'read_roles',
                'update_roles',
                'delete_roles',
                'create_permissions',
                'read_permissions',
                'update_permissions',
                'delete_permissions',
            ],
            'manager' => [
                'access_admin',
                'create_users',
                'read_users',
                'update_users'
            ],
            'user' => [
                'access_admin',
            ],
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Criação de usuários padrões
        $usersData = [
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ],
            [
                'name' => 'manager',
                'email' => 'manager@manager.com',
                'password' => Hash::make('12345678'),
                'role' => 'manager',
            ],
            [
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
            ],
        ];

        foreach ($usersData as $userData) {
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
