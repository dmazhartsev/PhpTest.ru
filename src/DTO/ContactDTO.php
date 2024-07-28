<?php

namespace App\DTO;

class ContactDTO extends BaseDTO
{
    public ?string $telegram = null;
    public ?string $skype = null;
    public ?string $telephone = null;

    protected function checkValue(string $value): bool
    {
        return true;
    }
}