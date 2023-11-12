<?php

namespace App\Services;

use App\Models\Transaction;
use App\validations\TransactionValidationInterface;
use App\Validations\ShopkeeperValidation;
use App\Validations\BalanceValidation;
use App\Validations\ExternalAuthorizationValidation;
use App\Validations\SendMoneyToYourselfValidation;

class TransactionValidatorService
{
    public function __construct(
        private $validations = []
    ) {
        $this->add(app()->make(ShopkeeperValidation::class))
            ->add(app()->make(BalanceValidation::class))
            ->add(new SendMoneyToYourselfValidation())
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
