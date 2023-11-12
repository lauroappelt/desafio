<?php

namespace Tests\Unit;

use App\Models\Wallet;
use App\Services\WalletService;
use Tests\TestCase;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class WalletServiceTest extends TestCase
{
    private $wallet;
    
    public function test_create_new_wallet(): void
    {
        $user = User::factory()->create();
        $data = [
            'id' => Uuid::uuid4(),
            'balance' => fake()->randomNumber(5),
            'user_id' => $user->id,
        ];

        $wallet = app(WalletService::class)->createWallet($data);

        $this->assertInstanceOf(Wallet::class, $wallet);
    
        $this->wallet = $wallet;
    }

    public function test_increment_wallet_balance(): void
    {   
        $wallet = Wallet::factory()->create();

        $result = app(WalletService::class)->incrementWalletBalance(100, $wallet->id);

        $this->assertTrue($result);
    }

    public function test_decrement_wallet_balance(): void
    {   
        $wallet = Wallet::factory()->create();

        $result = app(WalletService::class)->incrementWalletBalance($wallet->balance, $wallet->id);

        $this->assertTrue($result);
    }

    public function test_wallet_has_enough_balance(): void
    {
        $wallet = Wallet::factory()->create();

        $result = app(WalletService::class)->walletHasEnoughBalanceToTransfer($wallet->balance, $wallet->id);

        $this->assertTrue($result);
    }

    public function test_wallet_dont_has_enough_balance(): void
    {
        $wallet = Wallet::factory()->create();

        $result = app(WalletService::class)->walletHasEnoughBalanceToTransfer($wallet->balance + 1, $wallet->id);

        $this->assertFalse($result);
    }

    public function test_check_if_wallet_not_belongs_to_shopkeeper(): void
    {
        $wallet = Wallet::factory()->create();

        $result = app(WalletService::class)->walletBelongsToShopkeeper($wallet->id);

        $this->assertFalse($result);
    }

    public function test_check_if_wallet_belongs_to_shopkeeper(): void
    {
        $wallet = Wallet::factory()->create();
        $wallet->user->user_type = User::USER_SHOPKEEPER;
        $wallet->user->save();

        $result = app(WalletService::class)->walletBelongsToShopkeeper($wallet->id);

        $this->assertTrue($result);
    }
}
