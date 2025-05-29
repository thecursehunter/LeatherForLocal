<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['member_id'])) {
    header('Location: login.php');
    exit;
}

// Set up breadcrumb items
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Cart', 'url' => 'cart.php'],
    ['label' => 'Checkout', 'url' => null]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - LeatherForLocal</title>
    
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
        <h1 class="cart-title mb-4">Checkout</h1>
    </div>

    <main class="container py-5">
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <form id="checkoutForm" class="needs-validation" novalidate>
                    <!-- Personal Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Personal Information</h3>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullName" required>
                                    <div class="invalid-feedback">Please enter your full name.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                    <div class="invalid-feedback">Please enter your phone number.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Delivery Information</h3>
                            <div class="mb-3">
                                <label for="address" class="form-label">Delivery Address</label>
                                <textarea class="form-control" id="address" rows="3" required></textarea>
                                <div class="invalid-feedback">Please enter your delivery address.</div>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryMethod" class="form-label">Delivery Method</label>
                                <select class="form-select" id="deliveryMethod" required>
                                    <option value="">Select delivery method...</option>
                                    <option value="standard">Standard Delivery (Free)</option>
                                    <option value="express">Express Delivery ($10)</option>
                                </select>
                                <div class="invalid-feedback">Please select a delivery method.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Payment Method</h3>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" required>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bank" value="bank" required>
                                <label class="form-check-label" for="bank">
                                    Bank Transfer
                                </label>
                            </div>
                            <div class="invalid-feedback">Please select a payment method.</div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3 class="summary-title">Order Summary</h3>
                    <div id="cart-items-summary" class="summary-details">
                        <!-- Cart items will be dynamically populated here -->
                    </div>
                    <div class="summary-total">
                        <span>Total Amount:</span>
                        <span id="total-amount">$0.00</span>
                    </div>
                    <p class="shipping-note">The total amount you pay includes all applicable customs duties & taxes. We guarantee no additional charges on delivery</p>
                    <button type="button" class="btn btn-primary w-100" id="placeOrderBtn">Place Order</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Checkout JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartSummary = document.getElementById('cart-items-summary');
            const totalAmountElement = document.getElementById('total-amount');
            const checkoutForm = document.getElementById('checkoutForm');
            const placeOrderBtn = document.getElementById('placeOrderBtn');

            // Render cart summary
            function renderCartSummary() {
                let totalAmount = 0;
                let summaryHTML = '';

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    totalAmount += itemTotal;
                    
                    summaryHTML += `
                        <div class="summary-item">
                            <span>${item.name} × ${item.quantity}</span>
                            <span>$${itemTotal.toFixed(2)}</span>
                        </div>
                    `;
                });

                cartSummary.innerHTML = summaryHTML;
                totalAmountElement.textContent = `$${totalAmount.toFixed(2)}`;
            }

            // Handle form submission
            placeOrderBtn.addEventListener('click', function(e) {
                e.preventDefault();

                if (!checkoutForm.checkValidity()) {
                    checkoutForm.classList.add('was-validated');
                    return;
                }

                const formData = {
                    full_name: document.getElementById('fullName').value,
                    email: document.getElementById('email').value,
                    phone_number: document.getElementById('phone').value,
                    address: document.getElementById('address').value,
                    delivery_method: document.getElementById('deliveryMethod').value,
                    payment_method: document.querySelector('input[name="paymentMethod"]:checked').value,
                    cart_items: cart
                };

                // Send data to server
                fetch('../../src/controllers/CheckoutController.php?action=submit', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Clear cart
                        localStorage.removeItem('cart');
                        // Redirect to confirmation page
                        window.location.href = 'confirm_checkout.php';
                    } else {
                        alert(data.error || 'An error occurred during checkout');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred during checkout');
                });
            });

            // Initialize
            renderCartSummary();
        });
    </script>
</body>
</html> 