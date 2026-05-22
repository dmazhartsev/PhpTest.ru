<?php

namespace App\System\AppException;

enum AppExceptionCode: int
{
    case ERROR_REQUEST_WRITE = 123;
    case ERROR_HEADER_WRITE = 124;
    case ERROR_TOKEN_WRITE = 125;
}
