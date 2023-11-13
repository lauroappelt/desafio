<?php

namespace App\Services;

use App\DTOs\AddBalanceDTO;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private User $user,
        private WalletService $walletService,
    ) {

    }

    public function createNewUser(array $data)
    {
        DB::beginTransaction();

        $user = $this->createUser($data);

        $this->walletService->createWallet([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        DB::commit();

        return $user;
    }

    public function listAllUsers()
    {
        return User::with('wallet')->get();
    }

    public function createUser(array $data): User
    {
        $data['id'] = Uuid::uuid4();
        $data['password'] = Hash::make($data['password']);
        return $this->user->create($data);
    }
}
