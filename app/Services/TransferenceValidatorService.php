<?php

namespace App\Services;

use App\DTOs\CreateTransferenceDTO;
use App\Validations\ShopkeeperValidation;
use App\Validations\BalanceValidation;
use App\Validations\ExternalAuthorizationValidation;
use App\Validations\SendMoneyToYourselfValidation;
use App\Validations\TransferenceValidationInterface;

class TransferenceValidatorService
{
    public function __construct(
        private $validations = []
    ) {
        $this->add(app()->make(ShopkeeperValidation::class))
            ->add(app()->make(BalanceValidation::class))
            ->add(new SendMoneyToYourselfValidation())
            ->add(new ExternalAuthorizationValidation());
    }

    public function add(TransferenceValidationInterface $validation): TransferenceValidatorService
    {
        $this->validations[] = $validation;
        return $this;
    }

    public function validate(CreateTransferenceDTO $data): void
    {
        foreach ($this->validations as $validation) {
            $validation->validate($data);
        }
    }
}
