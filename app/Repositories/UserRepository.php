<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserRepository
{
    public function __construct(
        private User $user
    ) {

    }

    public function createUser(array $data): array
    {
        $data['id'] = Uuid::uuid4();
        $data['password'] = Hash::make($data['password']);
        $this->user->create($data);

        unset($data['password']);

        return $data;
    }

    public function listAllUsers()
    {
        $users = $this->user->with('wallet')->get()->all();

        return $users;
    }
}
