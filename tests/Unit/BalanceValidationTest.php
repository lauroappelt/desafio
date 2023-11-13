<?php

namespace Tests\Unit;

use App\Exceptions\InsuficienteBalanceException;
use App\Models\Wallet;
use App\Validations\BalanceValidation;
use Tests\TestCase;
use App\DTOs\CreateTransferenceDTO;

use function PHPUnit\Framework\assertTrue;

class BalanceValidationTest extends TestCase
{
    public function test_validate_wallet_has_enough_balance()
    {
        $wallet = Wallet::factory()->create();
        $destinationWallet =  Wallet::factory()->create();

        $result = app(BalanceValidation::class)->validate(new CreateTransferenceDTO($wallet->balance, $wallet->id, $destinationWallet->id));

        $this->assertTrue($result);
    }


    public function test_validate_wallet_dont_has_enough_balance()
    {
        $wallet = Wallet::factory()->create();
        $destinationWallet =  Wallet::factory()->create();

        $this->expectException(InsuficienteBalanceException::class);

        $result = app(BalanceValidation::class)->validate(new CreateTransferenceDTO($wallet->balance + 1, $wallet->id, $destinationWallet->id));
    }
}
