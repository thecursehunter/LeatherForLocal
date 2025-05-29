<?php
class LoginModel {
    private $db;
    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }
    public function checkAdminLogin($username, $password) {
    $stmt = $this->db->prepare("SELECT admin_id, password_hash, full_name FROM admin WHERE username = ? AND is_active = 1");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($admin_id, $hash, $full_name);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            return [
                'admin_id' => $admin_id,
                'full_name' => $full_name
            ];
        }
    }
    return false;
}
    public function checkLogin($username, $password) {
        $stmt = $this->db->prepare("SELECT member_id, password_hash, full_name FROM member WHERE username = ? AND is_active = 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($member_id, $hash, $full_name);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                return [
                    'member_id' => $member_id,
                    'full_name' => $full_name
                ];
            }
        }
        return false;
    }
}

