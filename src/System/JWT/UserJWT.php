<?php

namespace App\System\JWT;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class UserJWT
{
    private string $key = "secret_key";
    private string $algo = "HS256";
    private static $instance;

    public static function getInstance(): UserJWT
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getToken($data): string
    {
        return JWT::encode($data, $this->key, $this->algo);
    }

    public function verifyToken(string $token): bool
    {
        try {
            JWT::decode($token, new Key($this->key, $this->algo));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}