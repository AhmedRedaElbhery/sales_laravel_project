<?php

namespace App\Database;

use InvalidArgumentException;
use PDO;

use function PHPUnit\Framework\throwException;

class DB
{
    public static function table(string $table): QueryBuilder
    {
        $pdo = new PDO(
            'mysql:host=localhost;dbname=sales;charset=utf8mb4',
            'root',
            '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        return new QueryBuilder($pdo, $table);
    }
}

class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private array $wheres = [];
    private array $columns = ['*'];
    private array $orderby = [];

    public function __construct(PDO $pdo, string $table)
    {
        $this->pdo = $pdo;
        $this->table = $table;
    }

    public function where(string $column, $operator, mixed $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = ['basic', 'and', $column, $operator, $value];

        return $this;
    }

    public function orWhere(string $column, $operator, mixed $value = null): self
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = ['basic', 'or', $column, $operator, $value];

        return $this;
    }

    public function wherein(string $column, $values): self
    {
        $this->wheres[] = ['in', 'and', $column, $values];
        return $this;
    }

    public function whereNull(string $column): self
    {
        $this->wheres[] = ['null', 'and', $column];
        return $this;
    }

    public function whereBetween(string $column, $numbers): self
    {
        if (count($numbers) !== 2) {
            throw new InvalidArgumentException('whereBetween expects exactly 2 values.');
        }
        $this->wheres[] = ['between', 'and', $column, $numbers];
        return $this;
    }

    public function select(string ...$columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    public function orderBy($column, $type = null): self
    {
        $this->orderby[] = [$column, $type];
        return $this;
    }

    public function latest($column = 'created_at'): self
    {
        return $this->orderBy($column, 'DESC');
    }




    public function get(): array
    {

        $conditions = [];
        $columnlist = '';
        foreach ($this->columns as $col) {
            $columnlist .= $col . ', ';
        }
        $columnlist = rtrim($columnlist, ', ');

        $sql = "SELECT {$columnlist} FROM {$this->table}";
        $bindings = [];

        if ($this->wheres) {


            foreach ($this->wheres as $where) {

                if ($where[0] == 'basic') {
                    // type , operation , column , operator , variable
                    $conditions[] = [$where[1], "{$where[2]} {$where[3]} ? "];
                    $bindings[] = $where[4];
                } else if ($where[0] == 'between') {
                    // type , operation , column , array[number1 , number2]

                    $conditions[] = ['AND', "{$where[2]} BETWEEN ? AND ? "];
                    foreach ($where[3] as $value) {
                        $bindings[] = $value;
                    }
                } else if ($where[0] == 'null') {
                    // type , operation , column

                    $conditions[] = ['AND', "{$where[2]} IS NULL "];
                } else if ($where[0] == 'in') {
                    // type , operation , column , array[number1 , number2,number3, .....]

                    $placeholder = '';

                    foreach ($where[3] as $value) {
                        $placeholder .= '?,';
                        $bindings[] = $value;
                    }

                    $placeholder = rtrim($placeholder, ',');

                    $conditions[] = ['AND', "{$where[2]} IN ({$placeholder}) "];
                }
            }
        }

        if (!empty($conditions)) {

            $sql .= ' WHERE ';
            foreach ($conditions as $index => $condiiton) {
                if ($index == 0) {
                    $sql .= $condiiton[1];
                } else {
                    $sql .= '' . $condiiton[0] . ' ' .  $condiiton[1];
                }
            }
        }

        if ($this->orderby) {

            foreach ($this->orderby as $index => $order) {

                if ($index == 0) {
                    if ($order[1] == null) {
                        $sql .= " ORDER BY {$order[0]} ASC";
                    } else if ($order[1] == 'DESC') {
                        $sql .= " ORDER BY {$order[0]} DESC";
                    }
                } else {
                    if ($order[1] == null) {
                        $sql .= " , {$order[0]} ASC";
                    } else if ($order[1] == 'DESC') {
                        $sql .= " , {$order[0]} DESC";
                    }
                }
            }
        }

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return $statement->fetchAll();
    }

    public function first(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $bindings = [];

        if ($this->wheres) {
            $conditions = [];

            foreach ($this->wheres as [$column, $operator, $value]) {
                $conditions[] = "{$column} {$operator} ?";
                $bindings[] = $value;
            }

            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= ' LIMIT 1 ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetch();
    }


    public function find($id): array
    {
        $sql = "SELECT * FROM {$this->table} where id = ?";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);

        return $statement->fetch();
    }


    public function value($column): array
    {
        $sql = "SELECT {$column} FROM {$this->table}";

        if ($this->wheres) {
            $conditions = [];

            foreach ($this->wheres as [$column, $operator, $value]) {
                $conditions[] = "{$column} {$operator} ?";
                $bindings[] = $value;
            }

            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetch();
    }

    public function pluck($column): array
    {
        $sql = "SELECT {$column} FROM {$this->table}";
        $bindings = [];

        if ($this->wheres) {
            $conditions = [];

            foreach ($this->wheres as [$column, $operator, $value]) {
                $conditions[] = "{$column} {$operator} ?";
                $bindings[] = $value;
            }

            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetchAll();
    }
}