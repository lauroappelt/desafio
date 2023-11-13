<?php

namespace Tests\Unit;

use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\ShopkeeperCannotSendMoneyException;
use App\Models\User;
use Tests\TestCase;
use App\Models\Wallet;
use App\Validations\ShopkeeperValidation;

class ShopkeeperValidationTest extends TestCase
{
    public function test_validate_common_user_send_money()
    {
        $wallet = Wallet::factory()->create();
        $destinationWallet = Wallet::factory()->create();

        app(ShopkeeperValidation::class)->validate(new CreateTransferenceDTO($wallet->balance, $wallet->id, $destinationWallet->id));

        $this->assertTrue(true);
    }


    public function test_validate_shopkeeper_user_send_money()
    {
        $wallet = Wallet::factory()->create();
        $wallet->user->user_type = User::USER_SHOPKEEPER;
        $wallet->user->save();

        $destinationWallet = Wallet::factory()->create();

        $this->expectException(ShopkeeperCannotSendMoneyException::class);

        app(ShopkeeperValidation::class)->validate(new CreateTransferenceDTO($wallet->balance, $wallet->id, $destinationWallet->id));
    }
}
