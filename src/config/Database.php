<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        // Database configuration
        $host = 'localhost';
        $dbname = 'leatherforlocal';
        $username = 'root';
        $password = '';

        try {
            $this->connection = new mysqli($host, $username, $password, $dbname);
            
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            }

            $this->connection->set_charset("utf8mb4");
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->connection;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    private function __wakeup() {}
} 