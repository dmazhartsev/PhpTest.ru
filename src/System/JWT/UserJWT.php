<?php

namespace App\System\JWT;

use App\System\AppException\AppException;
use App\System\AppException\AppExceptionCode;
use App\System\Helpers\SessionHelper;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserJWT
{
    private const KEY = "secret_key";
    private const ALGO = "HS256";
    private static $instance;

    private function __construct()
    {
        // приватный конструктор ограничивает реализацию getInstance ()
    }

    protected function __clone()
    {
        // ограничивает клонирование объекта
    }

    public static function getInstance(): UserJWT
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function generateToken(array $data): string
    {
        $data['exp'] = time() + 86400; //Токен действителен на сутки
        return JWT::encode($data, self::KEY, self::ALGO);
    }

    public function verifyToken(string $token): bool
    {
        try {
            if (SessionHelper::getInstance()->isActive() === false) {
                new AppException('Session is not active', AppExceptionCode::ERROR_HEADER_WRITE);
                return false;
            }
            if ($this->tokenExpired($token)) {
                new AppException('Token expired', AppExceptionCode::ERROR_TOKEN_WRITE);
                return false;
            }
            return true;
        } catch (Exception $e) {
            new AppException($e->getMessage(), AppExceptionCode::ERROR_TOKEN_WRITE);
            return false;
        }
    }

    private function tokenExpired(string $token): bool
    {
        $data = JWT::decode($token, new Key(self::KEY, self::ALGO))->data;
        return $data['exp'] < time();
    }

}