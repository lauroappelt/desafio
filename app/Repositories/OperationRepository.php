<?php

namespace App\Repositories;

use App\Models\Operation;
use Ramsey\Uuid\Uuid;

class OperationRepository
{
    public function __construct(
        private Operation $operation
    ) {

    }

    public function create(array $data): Operation
    {
        $data['id'] = Uuid::uuid4();
        return $this->operation->create($data);
    }
}
