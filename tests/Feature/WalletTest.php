<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class WalletTest extends TestCase
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

    public function test_user_can_add_balance_to_wallet(): void
    {
        $wallet = Wallet::factory()->create();

        $response = $this->put(route('api.wallet.balance', ['walletId' => $wallet->id]), [
            'ammount' => 1000
        ]);

        $response->assertOk();

        $wallet->balance += 1000;

        $this->assertDatabaseHas('wallets', $wallet->toArray());
    }

    public function test_user_canot_add_balance_smallet_than_one(): void
    {
        $wallet = Wallet::factory()->create();

        $response = $this->put(route('api.wallet.balance', ['walletId' => $wallet->id]), [
            'ammount' => -1000
        ], ['accept' => 'application/json']);

        $response->assertUnprocessable();
    }

    public function test_add_balance_to_non_existing_wallet(): void
    {
        $response = $this->put(route('api.wallet.balance', ['walletId' => Uuid::uuid4()->toString()]), [
            'ammount' => 100
        ], ['accept' => 'application/json']);

        $response->assertNotFound();
    }

    public function test_user_cannot_send_money_to_non_existing_wallet(): void
    {
        $payer = Wallet::factory()->create();

        $response = $this->post(route('api.transference.create'), [
            'ammount' => $payer->balance,
            'originWallet' => $payer->id,
            'destinationWallet' => Uuid::uuid4()->toString(),
        ], ['accept' => 'application/json']);
        
        $response->assertNotFound();
    }
}
