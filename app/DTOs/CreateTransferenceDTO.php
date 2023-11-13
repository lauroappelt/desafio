<?php
namespace App\DTOs;

use App\DTOs\DTOInterface;

class CreateTransferenceDTO implements DTOInterface
{
    public function __construct(
        public int $ammount,
        public string $originWallet,
        public string $destinationWallet,
    ) {

    }

    public static function fromRequestValidated(array $data): CreateTransferenceDTO
    {
        return new self($data['ammount'], $data['originWallet'], $data['destinationWallet']);
    }
}
