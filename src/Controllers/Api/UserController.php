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
        $this->printJSON($this->model->getUserWithContacts(new UserDTO())->toArray());
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
            $this->printJSON(array('message' => $this->validator->getMessage()));
            return;
        }

        $this->printJSON(array('message' => 'Авторизация прошла успешно',
            'token' => UserJWT::getInstance()->getToken(['id' => $userFields['id']])));
    }

    public function registration(): void
    {
        $this->isSuccess = $this->validator->registration($this->request) &&
            $this->model->registration($this->request['email'], $this->request['password']);

        if (!$this->isSuccess) {
            $this->printJSON(array('message' => $this->validator->getMessage()));
            return;
        }

        $this->printJSON(array('message' => 'Регистрация прошла успешно'));
    }

    public function change_password(): void
    {
        if (
            $this->validator->changePassword($this->request, $this->model->getUser()) &&
            $this->model->changePassword($this->request['new_password'])
        ) {
            $this->printJSON(array('message' => 'Пароль изменен'));
            return;
        }

        $this->printJSON(array('message' => $this->validator->getMessage()));
    }

    public function edit(): void
    {
        $newData = (new UserDTO())->init($this->request);

        if ($this->model->edit($newData)) {
            $this->printJSON(array('message' => 'Изменения сохранены'));
            return;
        }

        $this->printJSON(array('message' => 'Изменения не сохранились'));
    }
}