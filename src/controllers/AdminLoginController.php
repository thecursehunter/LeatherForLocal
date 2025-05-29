<?php
require_once __DIR__ . '/../config/Database.php';
class AdminLoginController {
    private $conn;
    public function __construct() {
        $this->conn = Database::getInstance();
    }
    public function handleLogin($username, $password) {
        $stmt = $this->conn->prepare('SELECT * FROM admin WHERE username = ? AND is_active = 1');
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();
        if ($admin && password_verify($password, $admin['password_hash'])) {
            return $admin;
        }
        return false;
    }
} 