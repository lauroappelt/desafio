<?php

namespace App\Exceptions;

use Exception;

class InsuficienteBalanceException extends ApplicationException
{
    public $code = 400;
}
