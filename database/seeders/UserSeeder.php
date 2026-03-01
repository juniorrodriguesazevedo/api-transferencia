<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@email.com',
            'password' => '12345678',
        ])->assignRole(RoleEnum::SUPER_ADMIN);

        $customer = User::create([
            'name' => 'Cliente',
            'email' => 'customer@email.com',
            'password' => '12345678',
            'cpf_cnpj' => '584.979.080-23',
        ])->assignRole(RoleEnum::CUSTOMER);

        $shopkeeper = User::create([
            'name' => 'Lojista',
            'email' => 'shopkeeper@email.com',
            'password' => '12345678',
            'cpf_cnpj' => '90.079.261/0001-31',
        ])->assignRole(RoleEnum::SHOPKEEPER);

        $customer->wallet->update(['balance' => 100.00]);
        $shopkeeper->wallet->update(['balance' => 100.00]);
    }
}
