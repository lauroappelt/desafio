<?php

namespace App\Validations;

use App\DTOs\CreateTransferenceDTO;
use App\Exceptions\ExternalAuthorizationException;
use App\Validations\TransactionValidationInterface;
use Illuminate\Support\Facades\Http;
use Exception;

class ExternalAuthorizationValidation implements TransferenceValidationInterface
{
    public function validate(CreateTransferenceDTO $data): bool
    {
        $externalAuthorization = Http::get('https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc');

        if ($externalAuthorization->status() != 200 && $externalAuthorization->json()['message'] != "Autorizado") {
            throw new ExternalAuthorizationException("Transaction is not authorized");
        }

        return true;
    }
}
