<?php

namespace Infinitesimal\Database;

use PDO;

class SqliteDatabase extends PDO
{

    public function __construct(string $databaseName)
    {
        parent::__construct("sqlite:" . $databaseName);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function put($sql, $args): bool
    {
        $sth = $this->prepare($sql);
        return $sth->execute($args);
    }

    function getAll($sql, $args): array
    {
        $sth = $this->prepare($sql);
        $sth->execute($args);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRow($sql, $args): ?array
    {
        $sth = $this->prepare($sql);
        $sth->execute($args);
        $row = $sth->fetch(PDO::FETCH_ASSOC);
        return $row === false ? null : $row;
    }

    public function getValue($sql, $args): ?string
    {
        $result = $this->getRow($sql, $args);
        if ($result === null) return null;
        $key = $this->arrayKeyFirst($result);
        return $key === null ? null : $result[$key];
    }

    private function arrayKeyFirst(array $array): ?string
    {
        foreach ($array as $key => $value) return $key;
        return null;
    }

}