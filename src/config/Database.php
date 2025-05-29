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
            
            // Enable strict mode
            $this->connection->query("SET SESSION sql_mode = 'STRICT_ALL_TABLES'");
            
            // Set timezone
            $this->connection->query("SET time_zone = '+07:00'");
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

    // Begin a transaction
    public function begin_transaction() {
        return $this->connection->begin_transaction();
    }

    // Commit a transaction
    public function commit() {
        return $this->connection->commit();
    }

    // Rollback a transaction
    public function rollback() {
        return $this->connection->rollback();
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    private function __wakeup() {}
} 