<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Cliente Comum',
                'email' => 'client@email.com',
                'password' => '12345678',
                'cpf_cnpj' => '439.029.660-41',
                'balance' => 500.00,
                'role_id' => RoleEnum::CLIENT
            ],
            [
                'name' => 'Lojista',
                'email' => 'shopkeeper@email.com',
                'password' => '12345678',
                'cpf_cnpj' => '52.752.899/0001-00',
                'balance' => 100.00,
                'role_id' => RoleEnum::SHOPKEEPER
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
