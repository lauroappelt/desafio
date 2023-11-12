<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\WalletService;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private User $user,
        private UserRepository $userRepository,
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

    public function addBalanceToUserWallet(array $data)
    {
        DB::beginTransaction();

        $this->walletService->incrementWalletBalance($data['ammount'], $data['wallet_id']);

        DB::commit();
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
