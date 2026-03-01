<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Junior',
            'email' => 'junior@email.com',
            'cpf_cnpj' => '308.829.650-77',
            'password' => '12345678',
            'role' => 'customer'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => 'junior@email.com'
        ]);

        $user = User::where('email', 'junior@email.com')->first();

        $this->assertTrue(Hash::check('12345678', $user->password));

        $this->assertTrue($user->hasRole('customer'));
    }
}
