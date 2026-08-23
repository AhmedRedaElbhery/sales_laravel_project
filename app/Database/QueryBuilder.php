<?php

namespace App\Database;

use InvalidArgumentException;
use PDO;

class QueryBuilder
{
    private PDO $pdo;
    private string $table;
    private array $wheres = [];
    private array $columns = ['*'];
    private array $orderby = [];
    private $limit = '';
    private $offset = '';

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

    public function oldest($column = 'created_at'): self
    {
        return $this->orderBy($column, 'ASC');
    }

    public function limit($column): self
    {
        $this->limit = $column;
        return $this;
    }

    public function offset($column): self
    {
        $this->offset = $column;
        return $this;
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
        if ($this->limit) {
            $sql .= " LIMIT {$this->limit}";
        }

        if ($this->offset) {
            $sql .= " OFFSET {$this->offset}";
        }

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return $statement->fetchAll();
    }

    public function first(): ?array
    {
        $sql = "SELECT * FROM {$this->table}";
        $bindings = [];
        $conditions = [];


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

        $sql .= ' LIMIT 1 ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetch();
    }


    public function find($id): ?array
    {
        $sql = "SELECT * FROM {$this->table} where id = ?";

        $statement = $this->pdo->prepare($sql);
        $statement->execute([$id]);

        return $statement->fetch() ?: null;
    }


    public function value($column): mixed
    {
        $sql = "SELECT {$column} FROM {$this->table}";

        $conditions = [];
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

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetchColumn();
    }

    public function pluck($column): array
    {
        $sql = "SELECT {$column} FROM {$this->table}";
        $bindings = [];

        $conditions = [];

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

        $statement = $this->pdo->prepare($sql);
        $statement->execute($bindings);

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function count(): int
    {

        $conditions = [];
        $sql = "SELECT COUNT(*) FROM {$this->table}";
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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (int) $statement->fetchColumn();
    }

    public function exists(): bool
    {

        $conditions = [];
        $sql = "SELECT 1 FROM {$this->table}";
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

        $sql .= " LIMIT 1";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return $statement->fetchColumn() !== false;
    }

    public function doesntExist(): bool
    {

        $conditions = [];
        $sql = "SELECT 1 FROM {$this->table}";
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

        $sql .= " LIMIT 1";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return $statement->fetchColumn() === false;
    }

    public function sum($column): float
    {

        $conditions = [];
        $sql = "SELECT SUM({$column}) FROM {$this->table}";
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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (float) $statement->fetchColumn();
    }

    public function avg($column): float
    {

        $conditions = [];
        $sql = "SELECT AVG({$column}) FROM {$this->table}";
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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (float) $statement->fetchColumn();
    }

    public function max($column): float
    {

        $conditions = [];
        $sql = "SELECT MAX({$column}) FROM {$this->table}";
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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (float) $statement->fetchColumn();
    }
    public function min($column): float
    {

        $conditions = [];
        $sql = "SELECT MIN({$column}) FROM {$this->table}";
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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (float) $statement->fetchColumn();
    }

    public function insert(array $values): bool
    {
        //foreach ($records as $values) {
        $sql = "INSERT INTO {$this->table}";
        $bindings = [];
        $keys = '';
        $placeholder = '';

        foreach ($values as $key => $value) {
            $keys .= $key . ', ';
            $placeholder .= '? , ';
            $bindings[] = $value;
        }

        $keys = rtrim($keys, ', ');
        $placeholder = rtrim($placeholder, ', ');

        $sql .= " ({$keys}) VALUES ({$placeholder})";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);
        //}

        return true;
    }

    public function insertGetId(array $values): int
    {
        $sql = "INSERT INTO {$this->table}";
        $bindings = [];
        $keys = '';
        $placeholder = '';

        foreach ($values as $key => $value) {
            $keys .= $key . ', ';
            $placeholder .= '? , ';
            $bindings[] = $value;
        }

        $keys = rtrim($keys, ', ');
        $placeholder = rtrim($placeholder, ', ');

        $sql .= " ({$keys}) VALUES ({$placeholder})";

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return (int) $this->pdo->lastInsertId();
    }


    public function update(array $values): bool
    {
        $sql = "UPDATE {$this->table} SET";
        $bindings = [];
        $conditions = [];

        foreach ($values as $key => $value) {
            $sql .= " {$key} = ? ,";
            $bindings[] = $value;
        }

        $sql = rtrim($sql, ', ');


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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return true;
    }


    public function increment($column, $value = 1): bool
    {
        $sql = "UPDATE {$this->table} SET {$column} = {$column} + ? ";
        $bindings = [];
        $conditions = [];


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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return true;
    }


    public function decrement($column, $value = 1): bool
    {
        $sql = "UPDATE {$this->table} SET {$column} = {$column} - ? ";
        $bindings = [];
        $conditions = [];

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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return true;
    }

    public function delete(): bool
    {
        $sql = "DELETE FROM {$this->table}";
        $bindings = [];
        $conditions = [];

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

        $statement = $this->pdo->prepare($sql);

        $statement->execute($bindings);

        return true;
    }

    public function truncate(): bool
    {
        $sql = "TRUNCATE TABLE {$this->table}";

        $statement = $this->pdo->prepare($sql);

        $statement->execute();

        return true;
    }
}