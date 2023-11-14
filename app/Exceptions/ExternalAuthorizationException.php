<?php

namespace App\Exceptions;

use Exception;

class ExternalAuthorizationException extends ApplicationException
{
    public $code = 401;
}
