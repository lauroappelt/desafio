<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private WalletRepository $walletRepository,
    ) {

    }

    public function createUser(array $data)
    {
        DB::beginTransaction();

        $user = $this->userRepository->createUser($data);
        
        $user['wallet'] = $this->walletRepository->createWallet([
            'user_id' => $user['id'],
            'balance' => 0,
        ]);

        DB::commit();

        return $user;
    }

    public function listAllUsers()
    {
        return $this->userRepository->listAllUsers();
    }
}
