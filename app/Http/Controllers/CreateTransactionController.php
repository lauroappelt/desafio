<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTransactionRequest;
use App\Services\CreateTransactionService;

class CreateTransactionController extends Controller
{
    public function __construct(
        private CreateTransactionService $createTransactionService
    ) {
    }

    public function createTransaction(CreateTransactionRequest $createTransactionRequest)
    {
        try {
            $this->createTransactionService->createTransaction($createTransactionRequest->validated());

            return response()->json(['message' => 'Transaction has created!'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
