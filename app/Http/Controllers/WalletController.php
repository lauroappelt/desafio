<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\DTOs\AddBalanceDTO;
use App\Http\Requests\AddBalanceRequest;
use App\Services\OperationService;
use Exception;

class WalletController extends Controller
{
    public function __construct(
        private WalletService $walletService
    ) {

    }

    public function addBalance(AddBalanceRequest $addBalanceRequest)
    {
        try {
            $this->walletService->addBalanceToWallet(
                AddBalanceDTO::fromRequestValidated($addBalanceRequest->validated())
            );

            return response()->json([
                'message' => 'Founds add!',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
