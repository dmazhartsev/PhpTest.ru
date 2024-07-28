<?php

namespace App\Models;

use App\DTO\BaseDTO;
use App\DTO\UserDTO;
use App\System\Helpers\SessionHelper;
use Exception;

class UserModel extends BaseModel
{

    private ContactModel $contactModel;

    public function __construct()
    {
        $this->contactModel = new ContactModel();
    }

    public function getUser()
    {
        return $this->getPDO()->select(
            'SELECT * FROM users WHERE id = :id',
            ['id' => SessionHelper::getInstance()->getUserId()]
        )[0];
    }

    public function getUserByEmail(string $email): ?array
    {
        $foundUser = $this->getPDO()->select(
            'SELECT * FROM users WHERE email = :email',
            ['email' => $email]
        );

        if (count($foundUser) === 0) {
            return null;
        }

        return $foundUser[0];
    }

    public function getUserWithContacts(BaseDTO $userDTO): BaseDTO
    {
        $data = $this->getPDO()->select(
            'SELECT * FROM users LEFT JOIN contacts ON users.contact_id = contacts.id WHERE users.id = :id',
            ['id' => SessionHelper::getInstance()->getUserId()]
        )[0];
        return $userDTO->init($data);
    }

    public function registration(string $email, string $password): bool
    {
        $password = password_hash($password, PASSWORD_BCRYPT);

        $this->getPDO()->insert(
            'INSERT INTO users (email, password) VALUES (:email, :password)',
            ['email' => $email, 'password' => $password]
        );

        return true;
    }

    public function authorisation(int $id): bool
    {
        SessionHelper::getInstance()->setUserId($id);

        return true;
    }

    public function edit(UserDTO $userDTO): bool
    {
        $this->getPDO()->beginTransaction();

       try {

            $parameters = $userDTO->toArray();
            $user = $this->getUser();
            $unnecessaryKeys = ['contact', 'email', 'password', 'id'];

            if ($user['contact_id'] === null) {
                $parameters['contact_id'] = $this->contactModel->create($userDTO->contact);
            } else {
                $this->contactModel->edit($user['contact_id'], $userDTO->contact);
            }

            foreach ($unnecessaryKeys as $key) {
                if (array_key_exists($key, $parameters)) {
                    unset($parameters[$key]);
                }
            }

            if (!empty($parameters)){
                $this
                    ->getPDO()
                    ->updateWithNotNullParams('users', $parameters, ['id' => SessionHelper::getInstance()->getUserId()]);
            }

        } catch (Exception $exception) {
            $this->getPDO()->rollBack();
            return false;
        }

        $this->getPDO()->commit();

        return true;
    }

    public function changePassword(mixed $newPassword): bool
    {
        $this->getPDO()->beginTransaction();

        try {
            $this->getPDO()->update(
                'UPDATE users SET password = :password WHERE id = :id',
                [
                    'password' => password_hash($newPassword, PASSWORD_BCRYPT),
                    'id' => SessionHelper::getInstance()->getUserId()
                ]
            );
        } catch (Exception $_) {
            $this->getPDO()->rollBack();
            return false;
        }

        $this->getPDO()->commit();
        return true;
    }

    public function logout(): void
    {
        SessionHelper::getInstance()->logout();
    }

}