<?php
class LoginModel {
    private $db;
    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }
    public function checkLogin($email, $password) {
        $stmt = $this->db->prepare("SELECT id, password, first_name FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hash, $first_name);
            $stmt->fetch();
            if (password_verify($password, $hash)) {
                return [
                    'user_id' => $user_id,
                    'first_name' => $first_name
                ];
            }
        }
        return false;
    }
}
