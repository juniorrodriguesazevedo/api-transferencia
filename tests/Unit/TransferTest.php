<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Enums\RoleEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_transfer_success(): void
    {
        $payer = User::factory()->create([
            'balance' => 500,
            'role_id' => RoleEnum::CLIENT
        ]);

        $payee = User::factory()->create([
            'balance' => 100,
            'role_id' => RoleEnum::SHOPKEEPER
        ]);

        $response = $this->actingAs($payer)
            ->postJson('/api/transfers', [
                'payee' => $payee->id,
                'value' => 11.58,
            ]);

        $response->assertStatus(200);
    }

    public function test_transfer_insufficient_balance(): void
    {
        $payer = User::factory()->create([
            'balance' => 10,
            'role_id' => RoleEnum::CLIENT
        ]);

        $payee = User::factory()->create([
            'balance' => 100,
            'role_id' => RoleEnum::SHOPKEEPER
        ]);

        $response = $this->actingAs($payer)
            ->postJson('/api/transfers', [
                'payee' => $payee->id,
                'value' => 20,
            ]);

        $response->assertStatus(400);
    }
}
