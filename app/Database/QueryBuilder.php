<?php

namespace App\Database;

use PDO;

class QueryBuilder
{
    private $pdo;
    private $table;
    private $statement;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function table($table)
    {
        $this->table = $table;

        return $this;
    }

    public function find_if_exists($select_column, $column, $value)
    {
        $sql = "SELECT {$select_column} FROM {$this->table} WHERE {$column} = :value LIMIT 1";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':value', $value);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));

        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $this->statement = $stmt;

        return $this;
    }

    public function execute()
    {
        return $this->statement->execute();
    }
}