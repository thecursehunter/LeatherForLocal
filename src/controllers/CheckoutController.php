<?php
require_once(__DIR__ . '/../models/CheckoutModel.php');

// Include Database class if not already included
require_once(__DIR__ . '/../config/Database.php');

class CheckoutController {
    private $memberModel;
    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->memberModel = new MemberModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function handleRequest() {
        session_start();
        
        // Check if user is logged in
        if (!isset($_SESSION['member_id'])) {
            echo json_encode(['success' => false, 'error' => 'Please login to continue']);
            return;
        }

        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'submit':
                $this->processCheckout();
                break;
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
                break;
        }
    }

    private function processCheckout() {
        // Validate request method
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            return;
        }

        // Get POST data
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data) {
            echo json_encode(['success' => false, 'error' => 'Invalid data format']);
            return;
        }

        // Validate required fields
        $requiredFields = ['full_name', 'email', 'phone_number', 'address', 'delivery_method', 'payment_method', 'cart_items'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'error' => "Missing required field: $field"]);
                return;
            }
        }

        try {
            // Update member information
            $memberData = [
                'full_name' => $data['full_name'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address']
            ];
            $this->memberModel->updateMemberInfo($_SESSION['member_id'], $memberData);

            // Calculate total amount
            $totalAmount = 0;
            foreach ($data['cart_items'] as $item) {
                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Create order
            $orderData = [
                'member_id' => $_SESSION['member_id'],
                'total_amount' => $totalAmount,
                'shipping_address' => $data['address'],
                'phone_number' => $data['phone_number'],
                'notes' => $data['notes'] ?? ''
            ];

            $orderId = $this->orderModel->createOrder($orderData);
            if (!$orderId) {
                throw new Exception('Failed to create order');
            }

            // Create order items
            $success = $this->orderItemModel->createOrderItems($orderId, $data['cart_items']);
            if (!$success) {
                throw new Exception('Failed to create order items');
            }

            // Store order ID in session for confirmation page
            $_SESSION['last_order_id'] = $orderId;

            echo json_encode([
                'success' => true,
                'order_id' => $orderId,
                'message' => 'Order placed successfully'
            ]);

        } catch (Exception $e) {
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