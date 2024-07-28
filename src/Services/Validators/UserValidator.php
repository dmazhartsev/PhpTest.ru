<?php

namespace App\Services\Validators;

use App\System\Helpers\SessionHelper;
use App\System\JWT\UserJWT;

class UserValidator
{
    private string $message = '';

    public function getMessage(): string
    {
        return $this->message;
    }

    public function registration(array $data): bool
    {
        if (empty($data['email'])) {
            $this->message = "Email не может быть пустым";
            return false;
        }

        if (empty($data['password'])) {
            $this->message = "Пароль не может быть пустым";
            return false;
        }

        if (empty($data['repeat_password'])) {
            $this->message = "Повтор пароля не может быть пустым";
            return false;
        }

        if ($data['password'] !== $data['repeat_password']) {
            $this->message = "Пароли не совпадают";
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->message = "Не верно указан email";
            return false;
        }

        return true;
    }

    public function authorisation(array $data): bool
    {
        if (empty($data['email'])) {
            $this->message = "Email не может быть пустым";
            return false;
        }

        if (empty($data['password'])) {
            $this->message = "Пароль не может быть пустым";
            return false;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->message = "Не верно указан email";
            return false;
        }

        return true;
    }

    public function ChangePassword(array $data, array $user): bool
    {
        if (empty($data['old_password'])) {
            $this->message = "Старый пароль не может быть пустым";
            return false;
        }

        if (empty($data['new_password'])) {
            $this->message = "Новый пароль не может быть пустым";
            return false;
        }

        if ($data['new_password'] !== $data['repeat_new_password']) {
            $this->message = "Пароли не совпадают";
            return false;
        }

        if ($this->passwordVerify($data['old_password'], $user)) {
            $this->message = "Старый пароль неверен";
            return false;
        }

        return true;
    }

    public function passwordVerify(string $password, array $user): bool
    {
        if (!password_verify($password, $user['password'])) {
            $this->message = "Пароль не верен";
            return false;
        }

        return true;
    }

    public function hasUser($user): bool
    {
        if (empty($user)) {
            $this->message = "Пользователь не найден";
            return false;
        }

        return true;
    }

    public function tokenVerify(string $token): bool
    {
        if (!UserJWT::getInstance()->verifyToken($token)) {
            $this->message = "Токен недействителен";
            return false;
        }

        return true;
    }

    public function validateAuthorisation(): bool
    {
        if (!SessionHelper::getInstance()->hasUserId()) {
            $this->message = "Вы не авторизованы";
            return false;
        }

        return true;
    }
}