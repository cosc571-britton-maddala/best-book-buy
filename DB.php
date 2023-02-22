<?php

declare(strict_types = 1);

class DB
{
    private PDO $pdo;

    public function __construct()
    {
        $username = "COSC571USER"; 
        $password = "hhJVw5PPlxVQdpMH";
        $dbName = "bookbuydb"; 
        $instanceHost = "34.74.14.193";

        $pdoOptions = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];

        $dsn = sprintf('mysql:dbname=%s;host=%s', $dbName, $instanceHost);

        try {
            $this->pdo = new PDO($dsn,$username,$password,$pdoOptions);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getPDO() : PDO
    {
        return $this->pdo;
    }

    function getQuery(string $query) {

        $stmt = $this->pdo->query($query);
        $results = $stmt->fetchAll();
        $stmt = null;
        return $results;
    }
}