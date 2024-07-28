<?php

namespace App\System\AppException;

use Exception;

class AppException extends Exception
{
    public function __construct(string $message, AppExceptionCode $code)
    {
        parent::__construct($message, $code);
    }
}