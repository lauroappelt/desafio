<?php

namespace App\Repositories;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements RepositoryInterface
{
    public function __construct(
        private User $user
    ) {

    }

    public function create(array $data): User
    {
        $data['id'] = Uuid::uuid4();
        $data['password'] = Hash::make($data['password']);
        return $this->user->create($data);
    }

    public function getAllWithWallet(): Collection
    {
        return $this->user->with('wallet')->get();
    }
}
