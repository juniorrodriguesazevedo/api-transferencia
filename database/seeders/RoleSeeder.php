<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'super_admin', 'description' => 'Super Administrador'],
            ['name' => 'customer', 'description' => 'Cliente'],
            ['name' => 'shopkeeper', 'description' => 'Lojista'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $directorCustomers = [
            ['name' => 'customer_view', 'description' => 'Visualiza'],
            ['name' => 'customer_create', 'description' => 'Criar'],
            ['name' => 'customer_edit', 'description' => 'Editar'],
            ['name' => 'customer_delete', 'description' => 'Deletar']
        ];

        $directorShopkeepers = [
            ['name' => 'shopkeeper_view', 'description' => 'Visualiza'],
            ['name' => 'shopkeeper_create', 'description' => 'Criar'],
            ['name' => 'shopkeeper_edit', 'description' => 'Editar'],
            ['name' => 'shopkeeper_delete', 'description' => 'Deletar']
        ];

        foreach ($directorCustomers as $permission) {
            Permission::create($permission)->assignRole('customer');
        }

        foreach ($directorShopkeepers as $permission) {
            Permission::create($permission)->assignRole('shopkeeper');
        }
    }
}
