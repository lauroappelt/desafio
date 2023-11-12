<?php

namespace App\Services;

use App\Models\Transaction;
use App\validations\TransactionValidationInterface;
use App\Validations\ShopkeeperValidation;
use App\Validations\BalanceValidation;
use App\Validations\ExternalAuthorizationValidation;

class TransactionValidatorService
{
    public function __construct(
        private $validations = []
    ) {
        $this->add(new ShopkeeperValidation())
            ->add(new BalanceValidation())
            ->add(new ExternalAuthorizationValidation());
    }

    public function add(TransactionValidationInterface $validation): TransactionValidatorService
    {
        $this->validations[] = $validation;
        return $this;
    }

    public function validate(array $data): void
    {
        foreach ($this->validations as $validation) {
            $validation->validate($data);
        }
    }
}
