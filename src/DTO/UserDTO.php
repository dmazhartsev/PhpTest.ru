<?php

namespace App\DTO;

class UserDTO extends BaseDTO
{
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $sur_name = null;

    public ?string $email = null;
    public ?ContactDTO $contact = null;

    protected function checkValue(string $value): bool
    {
        if (strlen($value)>255) {
            return false;
        }
        return true;
    }

}