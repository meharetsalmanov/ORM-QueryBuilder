<?php

namespace App;

final class Database
{

    private static $instance;

    private $host;
    private $dbName;
    private $username;
    private $password;

    public function connection()
    {
        try {
            return new \PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8", $this->username, $this->password);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    public function execute($sql, array $args)
    {
        $db = $this->connection();
        $stmt = $db->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->host = 'localhost';
        $this->dbName = 'php_query_builder';
        $this->username = 'root';
        $this->password = '12345678';
    }


}
