<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_can_register(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'identifier' => fake('pt_BR')->cpf(),
            'password' => '1234',
            'user_type' => User::USER_COMMON,
        ];

        $response = $this->post(route('api.user.create'), $payload, ['accept' => 'application/json']);

        $response->assertCreated();
    }

    public function test_user_cannot_register_same_fields(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'identifier' => fake('pt_BR')->cpf(),
            'password' => '1234',
            'user_type' => User::USER_COMMON,
        ];

        $response = $this->post(route('api.user.create'), $payload, ['accept' => 'application/json']);

        $response->assertCreated();

        $response = $this->post(route('api.user.create'), $payload, ['accept' => 'application/json']);

        $response->assertUnprocessable();
    }

    public function test_user_cannot_register_without_required_fields(): void
    {
        $payload = [
            'name' => fake()->name(),
            'email' => null,
            'identifier' => null,
            'password' => '1234',
            'user_type' => User::USER_COMMON,
        ];
        
        $response = $this->post(route('api.user.create'), $payload, ['accept' => 'application/json']);

        $response->assertUnprocessable();
    }

    public function test_user_can_add_balance_to_wallet(): void
    {
        $wallet = Wallet::factory()->create();

        $response = $this->put(route('api.wallet.balance'), [
            'wallet_id' => $wallet->id,
            'ammount' => 1000
        ]);

        $response->assertOk();

        $wallet->balance += 1000;

        $this->assertDatabaseHas('wallets', $wallet->toArray());
    }

    public function test_user_canot_add_balance_smallet_than_zero(): void
    {
        $wallet = Wallet::factory()->create();

        $response = $this->put(route('api.wallet.balance'), [
            'wallet_id' => $wallet->id,
            'ammount' => -1000
        ], ['accept' => 'application/json']);

        $response->assertUnprocessable();
    }
}
