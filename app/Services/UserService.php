<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $repository,
        private WalletService $walletService,
    ) {

    }

    public function createNewUser(array $data)
    {
        $user = DB::transaction(function () use ($data) {
            $user = $this->createUser($data);

            $this->walletService->createWallet([
                'user_id' => $user->id,
                'balance' => 0,
            ]);

            return $user;
        });

        return $user;
    }

    public function listAllUsers()
    {
        return $this->repository->getAllWithWallet();
    }

    public function createUser(array $data): User
    {
        return $this->repository->create($data);
    }
}
