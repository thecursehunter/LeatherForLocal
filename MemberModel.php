<?php
require_once __DIR__ . '/../config/Database.php';

class MemberModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getInstance();
    }

    public function getMemberById($member_id) {
        $stmt = $this->conn->prepare('SELECT member_id, username, email, full_name, phone_number, address FROM member WHERE member_id = ?');
        $stmt->bind_param('i', $member_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function updateField($member_id, $field, $value) {
        $allowed = ['email', 'phone_number'];
        if (!in_array($field, $allowed)) return false;
        $stmt = $this->conn->prepare("UPDATE member SET $field = ? WHERE member_id = ?");
        $stmt->bind_param('si', $value, $member_id);
        return $stmt->execute();
    }

    public function updateMember($member_id, $data) {
        $fields = ['username', 'full_name', 'address'];
        $set = [];
        $params = [];
        $types = '';
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                $set[] = "$field = ?";
                $params[] = $data[$field];
                $types .= 's';
            }
        }
        if (empty($set)) return false;
        $params[] = $member_id;
        $types .= 'i';
        $sql = 'UPDATE member SET ' . implode(', ', $set) . ' WHERE member_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }
} 