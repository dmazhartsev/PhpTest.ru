<?php

namespace App\System\DataBase;

use Exception;
use PDO;
use PDOStatement;

class PdoDecorator
{
    private PDO $PDO;

    public function __construct()
    {
        $this->PDO = new PDO('mysql:dbname=bd;host=127.0.0.1', 'root', '');
    }

    public function select(string $sql, array $params = []): array
    {
        $sth = $this->query($sql, $params);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert(string $sql, array $params = []): int
    {
        $this->query($sql, $params);
        return $this->PDO->lastInsertId();
    }

    public function update(string $sql, array $params = []): bool
    {
        $this->query($sql, $params);
        return true;
    }

    public function updateWithNotNullParams(string $table, array $params = [], array $where = []): bool
    {
        $set = '';
        $whereStr = '';

        foreach ($params as $key => $value) {
            if (($value === null) || ($key === 'id')) {
                unset($params[$key]);
            } else {
                $set .= "$key = :$key, ";
            }
        }

        if (empty($set)) {
            return false;
        }

        foreach ($where as $key => $value) {
            if ($value !== null) {
                $params[$key] = $value;
                $whereStr .= "$key = :$key AND ";
            }
        }

        $query = 'UPDATE %table% SET %set% WHERE %where%';

        return $this->update(
            strtr(
                $query,
                [
                    '%table%' => $table,
                    '%set%' => substr($set, 0, -2),
                    '%where%' => substr($whereStr, 0, -4)
                ]
            ),
            $params
        );
    }

    public function beginTransaction(): void
    {
        $this->PDO->beginTransaction();
    }

    public function commit(): void
    {
        $this->PDO->commit();
    }

    public function rollBack(): void
    {
        $this->PDO->rollBack();
    }

    public function lastInsertId(): bool|string
    {
        return $this->PDO->lastInsertId();
    }

    private function query(string $sql, array $params = []): PDOStatement
    {
        $sth = $this->PDO->prepare($sql);
        $result = $sth->execute($params);

        if (!$result) {
            throw new Exception(implode(PHP_EOL,$sth->errorInfo()),500);
        }

        return $sth;
    }
}