<?php

namespace App\Database;

use PDO;

class TestDB
{
    private static $instance = null;

    private $pdo;

    private function __construct()
    {
        $this->pdo = new PDO(
            "mysql:host=localhost;dbname=sales;",
            "root",
            ""
        );
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function connection()
    {
        return $this->pdo;
    }
}