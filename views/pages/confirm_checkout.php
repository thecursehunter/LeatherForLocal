<?php
session_start();

// Redirect if no order ID in session
if (!isset($_SESSION['last_order_id'])) {
    header('Location: cart.php');
    exit;
}

// Include required files
require_once(__DIR__ . '/../../src/config/Database.php');
require_once(__DIR__ . '/../../src/models/CheckoutModel.php');

// Set up breadcrumb items
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Cart', 'url' => 'cart.php'],
    ['label' => 'Checkout', 'url' => 'checkout.php'],
    ['label' => 'Confirmation', 'url' => null]
];

// Get order details
$orderModel = new OrderModel();
$orderItemModel = new OrderItemModel();

$order = $orderModel->getOrderById($_SESSION['last_order_id']);
$orderItems = $orderItemModel->getOrderItems($_SESSION['last_order_id']);

// Clear the order ID from session to prevent refresh issues
unset($_SESSION['last_order_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - LeatherForLocal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'; ?>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <?php include '../components/breadcrumb.php'; ?>
    </div>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                        </div>
                        <h2 class="card-title mb-4">Thank You for Your Order!</h2>
                        <p class="lead">Your order has been successfully placed.</p>
                        <p class="mb-4">Order ID: #<?php echo str_pad($order['order_id'], 8, '0', STR_PAD_LEFT); ?></p>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Order Details</h3>
                        
                        <!-- Customer Information -->
                        <div class="mb-4">
                            <h4 class="h5">Customer Information</h4>
                            <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($order['full_name']); ?></p>
                            <p class="mb-1"><strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?></p>
                            <p class="mb-1"><strong>Phone:</strong> <?php echo htmlspecialchars($order['phone_number']); ?></p>
                            <p class="mb-0"><strong>Delivery Address:</strong> <?php echo htmlspecialchars($order['shipping_address']); ?></p>
                        </div>

                        <!-- Order Summary -->
                        <div class="mb-4">
                            <h4 class="h5">Order Summary</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-end">Price</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($orderItems as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                            <td class="text-center"><?php echo $item['quantity']; ?></td>
                                            <td class="text-end">$<?php echo number_format($item['unit_price'], 2); ?></td>
                                            <td class="text-end">$<?php echo number_format($item['subtotal'], 2); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                                            <td class="text-end"><strong>$<?php echo number_format($order['total_amount'], 2); ?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="mb-4">
                            <h4 class="h5">Payment Information</h4>
                            <?php if ($order['payment_method'] === 'cod'): ?>
                                <p class="mb-0">Your payment will be collected upon delivery.</p>
                            <?php else: ?>
                                <p class="mb-0">Please complete your payment via bank transfer using the following details:</p>
                                <div class="alert alert-info mt-2">
                                    <p class="mb-1"><strong>Bank:</strong> LeatherForLocal Bank</p>
                                    <p class="mb-1"><strong>Account Number:</strong> 1234-5678-9012-3456</p>
                                    <p class="mb-1"><strong>Reference:</strong> Order #<?php echo str_pad($order['order_id'], 8, '0', STR_PAD_LEFT); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="text-center">
                            <a href="index.php" class="btn btn-primary">Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</body>
</html> 