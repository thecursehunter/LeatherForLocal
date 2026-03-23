<?php
require_once(__DIR__ . '/../models/CheckoutModel.php');

// Include Database class if not already included
require_once(__DIR__ . '/../config/Database.php');

class CheckoutController {
    private $memberModel;
    private $orderModel;
    private $orderItemModel;
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function handleRequest() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'submit':
                $this->processCheckout();
                break;
            default:
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Hành động không hợp lệ']);
                break;
        }
    }

    private function processCheckout() {
        try {
            // Validate request method
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Phương thức yêu cầu không hợp lệ');
            }

            // Get POST data
            $rawData = file_get_contents('php://input');
            if (!$rawData) {
                throw new Exception('Không nhận được dữ liệu');
            }

            $data = json_decode($rawData, true);
            if (!$data) {
                throw new Exception('Dữ liệu không hợp lệ: ' . json_last_error_msg());
            }

            // Log received data
            error_log("Received checkout data: " . print_r($data, true));

            // Validate required fields
            $requiredFields = ['full_name', 'email', 'phone_number', 'address', 'delivery_method', 'payment_method', 'cart_items'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception("Thiếu thông tin bắt buộc: $field");
                }
            }

            // Validate cart items
            if (empty($data['cart_items']) || !is_array($data['cart_items'])) {
                throw new Exception('Giỏ hàng không hợp lệ');
            }

            // Start transaction
            $this->db->begin_transaction();

            try {
                // Create guest member
                $memberId = $this->memberModel->createGuestMember($data);
                if (!$memberId) {
                    throw new Exception('Không thể tạo thông tin khách hàng');
                }

                // Calculate total amount
                $totalAmount = 0;
                foreach ($data['cart_items'] as $item) {
                    if (!isset($item['price']) || !isset($item['quantity'])) {
                        throw new Exception('Định dạng sản phẩm trong giỏ hàng không hợp lệ');
                    }
                    $totalAmount += floatval($item['price']) * intval($item['quantity']);
                }

                // Apply discount if coupon was validated in session
                if (isset($_SESSION['applied_coupon']) && $data['coupon_code'] === $_SESSION['applied_coupon']['code']) {
                    $discountPct = (int)$_SESSION['applied_coupon']['discount_percentage'];
                    $totalAmount = $totalAmount - ($totalAmount * ($discountPct / 100));
                    // Optional: clear it after use
                    unset($_SESSION['applied_coupon']);
                }

                // Add delivery fee if express delivery
                if ($data['delivery_method'] === 'express') {
                    $totalAmount += 30000; // 30,000 VND for express delivery
                }

                // Create order
                $orderData = [
                    'member_id' => $memberId,
                    'total_amount' => $totalAmount,
                    'shipping_address' => $data['address'],
                    'phone_number' => $data['phone_number'],
                    'delivery_method' => $data['delivery_method'],
                    'payment_method' => $data['payment_method'],
                    'coupon_code' => isset($data['coupon_code']) ? $data['coupon_code'] : null,
                    'utm_source' => isset($_SESSION['utm_source']) ? $_SESSION['utm_source'] : null
                ];

                error_log("Creating order with data: " . print_r($orderData, true));

                $orderId = $this->orderModel->createOrder($orderData);
                if (!$orderId) {
                    throw new Exception('Không thể tạo đơn hàng');
                }

                // Create order items
                if (!$this->orderItemModel->createOrderItems($orderId, $data['cart_items'])) {
                    throw new Exception('Không thể tạo chi tiết đơn hàng');
                }

                // Commit transaction
                $this->db->commit();

                // Return success response
                echo json_encode([
                    'success' => true,
                    'message' => 'Đặt hàng thành công'
                ]);

            } catch (Exception $e) {
                // Rollback transaction on error
                $this->db->rollback();
                error_log("Order processing error: " . $e->getMessage());
                throw new Exception('Lỗi khi xử lý đơn hàng: ' . $e->getMessage());
            }

        } catch (Exception $e) {
            // Log the error with full details
            error_log("Checkout Error: " . $e->getMessage() . "\nStack trace: " . $e->getTraceAsString());
            
            // Set appropriate HTTP status code
            http_response_code(500);
            
            // Return error response
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    }
}

// Initialize and handle request
$controller = new CheckoutController();
$controller->handleRequest(); 