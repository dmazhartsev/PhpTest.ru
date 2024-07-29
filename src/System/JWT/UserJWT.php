<?php

namespace App\System\JWT;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class UserJWT
{
    private const KEY = "secret_key";
    private const ALGO = "HS256";
    private static $instance;

    public static function getInstance(): UserJWT
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getToken(array $data): string
    {
        return JWT::encode($data, self::KEY, self::ALGO);
    }

    public function verifyToken(string $token): bool
    {
        try {
            JWT::decode($token, new Key(self::KEY, self::ALGO));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}