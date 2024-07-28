<?php

namespace App\Controllers;

use App\DTO\UserDTO;
use App\Models\UserModel;
use App\Services\Validators\UserValidator;

class UserController extends BaseController
{
    private string $message = '';
    private bool $isSuccess = false;
    private UserModel $model;
    private UserValidator $validator;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->validator = new UserValidator();
    }

    public function registration(): void
    {
        if ($this->request->get('button_registration') !== null) {
            $this->isSuccess = $this->validator->registration($this->request->all()) &&
                $this->model->registration($this->request->get('email'), $this->request->get('password'));
        }

        if (!$this->isSuccess) {
            $this->message = $this->validator->getMessage();
            $this->render('registration', ['alertMessage' => $this->message]);
            return;
        }

        $this->getRedirect()->toAuthorisation();
    }

    public function authorisation(): void
    {
        if ($this->request->get('button_authorisation') !== null) {
            $userFields = $this->model->getUserByEmail($this->request->get('email'));
            $this->isSuccess =
                $this->validator->authorisation($this->request->all()) &&
                $this->validator->hasUser($userFields) &&
                $this->validator->passwordVerify($this->request->get('password'), $userFields) &&
                $this->model->authorisation($userFields['id']);
        }

        if (!$this->isSuccess) {
            $this->message = $this->validator->getMessage();
            $this->render('authorisation', ['alertMessage' => $this->message]);
            return;
        }

        $this->getRedirect()->toInfo();
    }

    public function info(): void
    {
        $userDTO = $this->model->getUserWithContacts(new UserDTO());
        $this->render('info', ['userParameters' => $userDTO->toArray(), 'alertMessage' => '']);
    }

    public function edit(): void
    {
        if (
            $this->request->get('button_cancel') !== null ||
            (
                $this->request->get('button_save_changes') !== null &&
                $this->model->edit((new UserDTO())->init($this->request->all()))
            )
        ) {
            $this->getRedirect()->toInfo();
            return;
        }

        $this->message = $this->validator->getMessage();

        $userParameters = $this->model->getUserWithContacts(new UserDTO());

        $this->render('edit', ['userParameters' => $userParameters->toArray(), 'alertMessage' => $this->message]);
    }

    public function change_password(): void
    {
        if (
            $this->request->get('button_cancel') !== null ||
            (
                $this->request->get('button_save_changes') !== null &&
                $this->validator->changePassword($this->request->all(), $this->model->getUser()) &&
                $this->model->changePassword($this->request->get('new_password'))
            )
        ) {
            $this->getRedirect()->toInfo();
            return;
        }

        $this->message = $this->validator->getMessage();
        $this->render('change_password', ['alertMessage' => $this->message]);
    }

    public function logout(): void
    {
        $this->model->logout();
        $this->getRedirect()->toAuthorisation();
    }
}