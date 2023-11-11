<?php

namespace App\Rules;

use App\Exceptions\ExternalAuthorizationException;
use App\Rules\TransactionValidationInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class ExternalAuthorizationValidation implements TransactionValidationInterface
{
    public function validate(array $data): void
    {
        $externalAuthorization = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

        if ($externalAuthorization->status() != 200) {
            throw new ExternalAuthorizationException("Transaction is not authorized");
        }
    }
}
