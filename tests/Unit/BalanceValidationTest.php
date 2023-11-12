<?php

namespace Tests\Unit;

use App\Exceptions\InsuficienteBalanceException;
use App\Models\Wallet;
use App\Validations\BalanceValidation;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class BalanceValidationTest extends TestCase
{
    public function test_validate_wallet_has_enough_balance()
    {
        $wallet = Wallet::factory()->create();

        $result = app(BalanceValidation::class)->validate([
            'ammount' => $wallet->balance,
            'payer' => $wallet->id,
        ]);

        $this->assertTrue($result);
    }


    public function test_validate_wallet_dont_has_enough_balance()
    {
        $wallet = Wallet::factory()->create();

        $this->expectException(InsuficienteBalanceException::class);

        app(BalanceValidation::class)->validate([
            'ammount' => $wallet->balance + 1,
            'payer' => $wallet->id,
        ]);
    }
}
