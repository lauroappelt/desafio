<?php

namespace Tests\Unit;

use App\Models\Wallet;
use App\Repositories\WalletRepository;
use Tests\TestCase;

class WalletRepositoryTest extends TestCase
{
    public function test_increment_wallet_balance(): void
    {
        $wallet = Wallet::factory()->create();
        $repository = new WalletRepository($wallet);

        $result = $repository->incrementWalletBalance($wallet->balance, $wallet->id);

        $this->assertTrue($result);
    }

    public function test_decrement_wallet_balance(): void
    {
        $wallet = Wallet::factory()->create();
        $repository = new WalletRepository($wallet);

        $result = $repository->decrementWalletBalance($wallet->balance, $wallet->id);

        $this->assertTrue($result);
    }
}
