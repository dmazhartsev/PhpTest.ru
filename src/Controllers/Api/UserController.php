<?php

namespace App\Controllers\Api;

use App\DTO\UserDTO;
use App\Models\UserModel;
use App\Services\Validators\UserValidator;
use App\System\JWT\UserJWT;

class UserController extends BaseController
{
    private UserModel $model;
    private bool $isSuccess = false;
    private UserValidator $validator;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->validator = new UserValidator();

    }

    public function getInfo(): void
    {
        if (!$this->validator->validateAuthorisation() || !$this->validator->tokenVerify($this->tokenString)) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        echo json_encode($this->model->getUserWithContacts(new UserDTO())->toArray());
    }

    public function authorisation(): void
    {
        $userFields = $this->model->getUserByEmail($this->request['email']);

        $this->isSuccess =
            $this->validator->authorisation($this->request) &&
            $this->validator->hasUser($userFields) &&
            $this->validator->passwordVerify($this->request['password'], $userFields) &&
            $this->model->authorisation($userFields['id']);

        if (!$this->isSuccess) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        echo json_encode(array('message' => 'Авторизация прошла успешно',
            'token' => UserJWT::getInstance()->getToken(['id' => $userFields['id']])));
    }

    public function registration(): void
    {
        $this->isSuccess = $this->validator->registration($this->request) &&
            $this->model->registration($this->request['email'], $this->request['password']);

        if (!$this->isSuccess) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        echo json_encode(array('message' => 'Регистрация прошла успешно'));
    }

    public function change_password(): void
    {
        if (!$this->validator->validateAuthorisation() || !$this->validator->tokenVerify($this->tokenString)) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        if (
            $this->validator->changePassword($this->request, $this->model->getUser()) &&
            $this->model->changePassword($this->request['new_password'])
        ) {
            echo json_encode(array('message' => 'Пароль изменен'));
            return;
        }

        echo json_encode(array('message' => $this->validator->getMessage()));
    }

    public function edit(): void
    {
        if (!$this->validator->validateAuthorisation() || !$this->validator->tokenVerify($this->tokenString)) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        $newData = (new UserDTO())->init($this->request);

        if ($this->model->edit($newData)) {
            echo json_encode(array('message' => 'Изменения сохранены'));
            return;
        }

        echo json_encode(array('message' => 'Изменения не сохранились'));
    }

    public function logout(): void
    {
        if (!$this->validator->validateAuthorisation()) {
            echo json_encode(array('message' => $this->validator->getMessage()));
            return;
        }

        $this->model->logout();
        echo json_encode(array('message' => 'Вы вышли из аккаунта'));
    }

}