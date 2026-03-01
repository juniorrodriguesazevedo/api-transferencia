<?php

namespace Tests\Feature\Transfer;

use Tests\TestCase;
use App\Models\User;
use App\Services\ExternalService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransferTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_send_money()
    {
        $this->mock(ExternalService::class, function ($mock) {
            $mock->shouldReceive('authorizeTransaction')
                ->andReturn(true);
        });

        $customer = User::role('customer')->first();
        $shopkeeper = User::role('shopkeeper')->first();

        $response = $this->actingAs($customer, 'sanctum')
            ->postJson('/api/transfers', [
                'payer' => $customer->id,
                'payee' => $shopkeeper->id,
                'value' => 1.28
            ]);

        $response->assertStatus(201);
    }

    public function test_shopkeeper_cannot_send_money()
    {
        $this->mock(ExternalService::class, function ($mock) {
            $mock->shouldReceive('authorizeTransaction')
                ->andReturn(true);
        });

        $customer = User::role('customer')->first();
        $shopkeeper = User::role('shopkeeper')->first();

        $response = $this->actingAs($shopkeeper, 'sanctum')
            ->postJson('/api/transfers', [
                'payer' => $shopkeeper->id,
                'payee' => $customer->id,
                'value' => 1.28
            ]);

        $response->assertStatus(403);
    }
}
