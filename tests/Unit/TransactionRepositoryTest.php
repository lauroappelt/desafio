<?php

namespace Tests\Unit;

use App\Models\Transaction;
use Tests\TestCase;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;

class TransactionRepositoryTest extends TestCase
{
    public function test_create_transaction(): void
    {
        $payer = Wallet::factory()->create();
        $payee = Wallet::factory()->create();

        $repository = new TransactionRepository(new Transaction());

        $result = $repository->createTransaction([
            'ammount' => $payer->balance,
            'payer' => $payer->id,
            'payee' => $payee->id,
        ]);

        $this->assertTrue($result);
    }
}
