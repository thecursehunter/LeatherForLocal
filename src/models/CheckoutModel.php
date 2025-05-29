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
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("i", $memberId);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateMemberInfo($memberId, $data) {
        $sql = "UPDATE member SET full_name = ?, phone_number = ?, address = ? WHERE member_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
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
        try {
            // Log the incoming data for debugging
            error_log("Creating order with data: " . print_r($data, true));

            $sql = "INSERT INTO `order` (
                member_id, 
                order_date, 
                total_amount, 
                status, 
                shipping_address, 
                phone_number,
                notes
            ) VALUES (?, NOW(), ?, 'Pending', ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            if (!$stmt) {
                error_log("Prepare failed: " . $this->db->error);
                return false;
            }

            $notes = "Delivery Method: " . $data['delivery_method'] . "\nPayment Method: " . $data['payment_method'];

            $stmt->bind_param("idsss", 
                $data['member_id'],
                $data['total_amount'],
                $data['shipping_address'],
                $data['phone_number'],
                $notes
            );

            if (!$stmt->execute()) {
                error_log("Execute failed: " . $stmt->error);
                return false;
            }

            $orderId = $stmt->insert_id;
            error_log("Order created successfully with ID: " . $orderId);
            $stmt->close();
            return $orderId;
        } catch (Exception $e) {
            error_log("Order creation error: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderById($orderId) {
        $sql = "SELECT o.*, m.full_name, m.email 
                FROM `order` o 
                JOIN member m ON o.member_id = m.member_id 
                WHERE o.order_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
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
        try {
            error_log("Creating order items for order ID: " . $orderId);
            error_log("Items data: " . print_r($items, true));

            foreach ($items as $item) {
                $sql = "INSERT INTO orderitem (
                    order_id, 
                    product_id, 
                    quantity, 
                    unit_price, 
                    subtotal
                ) VALUES (?, ?, ?, ?, ?)";
                
                $stmt = $this->db->prepare($sql);
                if (!$stmt) {
                    error_log("Prepare failed: " . $this->db->error);
                    return false;
                }

                $productId = intval($item['id']);
                $quantity = intval($item['quantity']);
                $price = floatval($item['price']);
                $subtotal = $price * $quantity;
                
                $stmt->bind_param("iiiii", 
                    $orderId,
                    $productId,
                    $quantity,
                    $price,
                    $subtotal
                );

                if (!$stmt->execute()) {
                    error_log("Execute failed for order item: " . $stmt->error);
                    return false;
                }
                $stmt->close();
            }
            error_log("All order items created successfully");
            return true;
        } catch (Exception $e) {
            error_log("Order item creation error: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderItems($orderId) {
        $sql = "SELECT oi.*, p.product_name, p.images 
                FROM orderitem oi 
                JOIN products p ON oi.product_id = p.product_id 
                WHERE oi.order_id = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            error_log("Prepare failed: " . $this->db->error);
            return false;
        }
        $stmt->bind_param("i", $orderId);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            return false;
        }
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?> 