<?php

namespace App\Http\Controllers;

use App\Services\WalletService;
use App\DTOs\AddBalanceDTO;
use App\Exceptions\ApplicationException;
use App\Http\Requests\AddBalanceRequest;
use App\Services\OperationService;
use Exception;
use Illuminate\Http\Request;

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
                $addBalanceRequest->route('walletId'),
                $addBalanceRequest->input('ammount')
            );

            return response()->json([
                'message' => 'Founds add!',
            ], 200);
        } catch (ApplicationException $applicationException) {
            return response()->json(['message' => $applicationException->getMessage()], $applicationException->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function walletSummary(Request $request)
    {
        try {
            $summary = $this->walletService->getWalletSummary($request->route('walletId'));

            return response()->json([
                'data' => $summary,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
