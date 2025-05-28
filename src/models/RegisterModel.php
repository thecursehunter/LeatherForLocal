<?php
class RegisterModel {
    private $db;
    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }
    public function register($first_name, $last_name, $email, $password) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return 'Email đã tồn tại!';
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $first_name, $last_name, $email, $hash);
        if ($stmt->execute()) {
            return true;
        }
        return 'Đăng ký thất bại!';
    }
}