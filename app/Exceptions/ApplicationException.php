<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ApplicationException extends Exception
{
    public $code = 400;

    public function __construct(string $message = "", int $code = 0, \Throwable|null $previous = null)
    {
        parent::__construct($message, $code, $previous);

        Log::error($message);
        Log::error($this);
    }
}
