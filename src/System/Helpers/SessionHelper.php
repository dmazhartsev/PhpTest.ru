<?php

namespace App\System\Helpers;

class SessionHelper
{

    private static $instance;

    public function __construct()
    {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    public static function getInstance(): SessionHelper
    {

        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key)
    {
        return $_SESSION[$key];
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

    public function hasUserId(): bool
    {
        return $this->has('user_id');
    }

    public function getUserId(): ?int
    {
        return $this->get('user_id');
    }

    public function setUserId(int $userId): void
    {
        $this->set('user_id', $userId);
    }

    public function logout(): void
    {
        $this->unset('user_id');
    }

}