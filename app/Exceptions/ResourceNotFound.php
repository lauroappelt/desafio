<?php

namespace App\Exceptions;

use Exception;

class ResourceNotFound extends ApplicationException
{
    public $code = 404;
}
