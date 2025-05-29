<?php
require_once(__DIR__ . '/../config/Database.php');

/* === Member Model === */
class MemberModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getMemberById($memberId) {
        $sql = "SELECT * FROM member WHERE member_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateMemberInfo($memberId, $data) {
        $sql = "UPDATE member SET full_name = ?, phone_number = ?, address = ? WHERE member_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("sssi", $data['full_name'], $data['phone_number'], $data['address'], $memberId);
        return $stmt->execute();
    }
}

/* === Order Model === */
class OrderModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createOrder($data) {
        $sql = "INSERT INTO `order` (member_id, order_date, total_amount, status, shipping_address, phone_number, notes) 
                VALUES (?, NOW(), ?, 'Pending', ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("idsss", 
            $data['member_id'],
            $data['total_amount'],
            $data['shipping_address'],
            $data['phone_number'],
            $data['notes']
        );

        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function getOrderById($orderId) {
        $sql = "SELECT o.*, m.full_name, m.email 
                FROM `order` o 
                JOIN member m ON o.member_id = m.member_id 
                WHERE o.order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

/* === OrderItem Model === */
class OrderItemModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createOrderItems($orderId, $items) {
        $success = true;
        
        foreach ($items as $item) {
            $sql = "INSERT INTO orderitem (order_id, product_id, quantity, unit_price, subtotal) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            $subtotal = $item['price'] * $item['quantity'];
            
            $stmt->bind_param("iidd", 
                $orderId,
                $item['id'],
                $item['quantity'],
                $item['price'],
                $subtotal
            );

            if (!$stmt->execute()) {
                $success = false;
                break;
            }
        }
        
        return $success;
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.product_name, p.images 
                FROM orderitem oi 
                JOIN products p ON oi.product_id = p.product_id 
                WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?> 