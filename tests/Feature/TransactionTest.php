<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_user_can_send_money_to_another_user(): void
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance,
            'originWallet' => $payer->id,
            'destinationWallet' => $payee->id,
        ]);

        $response->assertCreated();
    }

    public function test_user_can_send_money_to_shopkeeper(): void
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();
        $payee->user->update(['user_type' => User::USER_SHOPKEEPER]);

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance,
            'originWallet' => $payer->id,
            'destinationWallet' => $payee->id,
        ]);

        $response->assertCreated();
    }

    public function test_user_cannot_send_money_with_insuficient_balance()
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance + 1000,
            'originWallet' => $payer->id,
            'destinationWallet' => $payee->id,
        ]);

        $response->assertBadRequest();
    }

    public function test_user_cannot_send_money_to_yourself(): void
    {
        $payer = Wallet::factory()->create();

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance,
            'originWallet' => $payer->id,
            'destinationWallet' => $payer->id,
        ]);

        $response->assertBadRequest();
    }

    public function test_shopkeeper_cannot_send_money(): void
    {
        $payee = Wallet::factory()->create();
        $payer = Wallet::factory()->create();
        $payer->user->update(['user_type' => User::USER_SHOPKEEPER]);

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance,
            'originWallet' => $payer->id,
            'destinationWallet' => $payee->id,
        ]);

        $response->assertBadRequest();
    }

    public function test_user_canot_send_value_smallet_than_one(): void
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance * -1,
            'originWallet' => $payer->id,
            'destinationWallet' => $payee->id,
        ], ['accept' => 'application/json']);

        $response->assertUnprocessable();
    } 
}
