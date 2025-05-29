<?php
class RegisterModel {
    private $db;
    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }
    public function register($username, $full_name, $email, $password, $phone_number, $address) {
        // Kiểm tra username hoặc email đã tồn tại
        $stmt = $this->db->prepare("SELECT member_id FROM member WHERE username = ? OR email = ?");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            return 'Tên đăng nhập hoặc email đã tồn tại!';
        }
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO member (username, full_name, email, password_hash, phone_number, address, is_active) VALUES (?, ?, ?, ?, ?, ?, 1)");
        $stmt->bind_param('ssssss', $username, $full_name, $email, $hash, $phone_number, $address);
        if ($stmt->execute()) {
            return true;
        }
        return 'Đăng ký thất bại!';
    }
}