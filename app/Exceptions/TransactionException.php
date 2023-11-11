<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class TransactionException extends Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);

        Log::error($message);
    }
}
