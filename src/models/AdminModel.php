<?php
class AdminModel {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }

    // Get all admins
    public function getAllAdmins() {
        $result = $this->db->query("SELECT admin_id, username, email, full_name FROM admin");
        $admins = [];
        while ($row = $result->fetch_assoc()) {
            $admins[] = $row;
        }
        return $admins;
    }

    // Get admin by ID
    public function getAdminById($admin_id) {
        $stmt = $this->db->prepare("SELECT admin_id, username, email, full_name FROM admin WHERE admin_id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Add new admin
    public function addAdmin($username, $email, $password_hash, $full_name) {
        $stmt = $this->db->prepare("INSERT INTO admin (username, email, password_hash, full_name) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password_hash, $full_name);
        return $stmt->execute();
    }

    // Update admin
    public function updateAdmin($admin_id, $username, $email, $full_name) {
        $stmt = $this->db->prepare("UPDATE admin SET username=?, email=?, full_name=? WHERE admin_id=?");
        $stmt->bind_param("sssi", $username, $email, $full_name, $admin_id);
        return $stmt->execute();
    }

    // Delete admin
    public function deleteAdmin($admin_id) {
        $stmt = $this->db->prepare("DELETE FROM admin WHERE admin_id=?");
        $stmt->bind_param("i", $admin_id);
        return $stmt->execute();
    }
}