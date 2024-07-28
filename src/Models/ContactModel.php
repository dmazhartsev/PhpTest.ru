<?php

namespace App\Models;

use App\DTO\ContactDTO;

class ContactModel extends BaseModel
{
    public function edit(int $id, ContactDTO $contactDTO): bool
    {
        $parameters = [
            'telegram' => $contactDTO->telegram,
            'skype' => $contactDTO->skype,
            'telephone' => $contactDTO->telephone,
        ];

        return $this->getPDO()->updateWithNotNullParams('contacts', $parameters, ['id' => $id]);
    }

    public function create(ContactDTO $contactDTO): int
    {
        foreach ($contactDTO->toArray() as $key => $value) {
            if ($value === null) {
                unset($contactDTO->$key);
            }
        }
        return $this->getPDO()->insert('INSERT INTO contacts (telegram, skype, telephone) VALUES (:telegram, :skype, :telephone)', $contactDTO->toArray());
    }

}