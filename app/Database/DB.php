<?php

namespace App\Database;


use PDO;

class DB
{public function __construct(private PDO $pdo) {}

    public function table(string $table): QueryBuilder
    {
        return new QueryBuilder($this->pdo, $table);
    }
}