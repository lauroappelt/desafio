<?php

namespace App\Exceptions;

use Exception;

class ShopkeeperCannotSendMoneyException extends ApplicationException
{
    public $code = 400;
}
