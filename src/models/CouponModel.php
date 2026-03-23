<?php
require_once(__DIR__ . '/../config/Database.php');

class CouponModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getCouponByCode($code) {
        $sql = "SELECT * FROM coupons WHERE code = ? AND is_active = 1";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $code);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
