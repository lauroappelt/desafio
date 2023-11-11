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

        $response = $this->post(route('api.create.transaction'), [
            'ammount' => $payer->balance,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ]);

        $response->assertCreated();
    }

    public function test_user_can_send_money_to_shopkeeper(): void
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();
        $payee->user->update(['user_type' => User::USER_SHOPKEEPER]);

        $response = $this->post(route('api.create.transaction'), [
            'ammount' => $payer->balance,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ]);

        $response->assertCreated();
    }

    public function test_user_cannot_send_money_with_insuficient_balance()
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();

        $response = $this->post(route('api.create.transaction'), [
            'ammount' => $payer->balance + 1000,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ]);

        $response->assertBadRequest();
    }

    public function test_user_cannot_send_money_to_themselves(): void
    {
        $payer = Wallet::factory()->create();

        $response = $this->post(route('api.create.transaction'), [
            'ammount' => $payer->balance + 1000,
            'payer' => $payer->id,
            'payee' => $payer->id,
        ]);

        $response->assertBadRequest();
    }
}
