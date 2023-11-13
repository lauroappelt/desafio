<?php
namespace App\DTOs;

class AddBalanceDTO implements DTOInterface
{
    public function __construct(
        public string $walletId,
        public int $ammount,
    )
    {
        
    }

    public static function fromRequestValidated(array $data): DTOInterface
    {
        return new self($data['wallet_id'], $data['ammount']);
    }
}
