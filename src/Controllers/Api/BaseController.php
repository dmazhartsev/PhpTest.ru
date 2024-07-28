<?php

namespace App\Controllers\Api;

use App\System\AppException\AppException;
use App\System\AppException\AppExceptionCode;

class BaseController
{
    protected array $request;
    protected array $headers;
    protected string $tokenString = '';

    public function setRequestAndHeaders(array $request): void
    {
        if (isset($this->request)) {
            throw new AppException('Request already set', AppExceptionCode::ERROR_REQUEST_WRITE);
        }

        $this->request = $request;
        $this->headers = getallheaders();
        $this->tokenString = substr($this->headers['Authorization'] ?? '', 7);
    }
}