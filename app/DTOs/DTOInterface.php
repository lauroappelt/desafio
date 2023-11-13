<?php
namespace App\DTOs;

interface DTOInterface
{
    public static function fromRequestValidated(array $data): DTOInterface;
}