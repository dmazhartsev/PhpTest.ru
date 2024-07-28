<?php

namespace App\Models;

use App\System\DataBase\PdoDecorator;

class BaseModel
{
    protected function getPDO(): PdoDecorator
    {
        static $pdo;

        if (empty($pdo)) $pdo = new PdoDecorator();

        return $pdo;
    }
}