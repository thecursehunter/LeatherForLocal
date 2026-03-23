<?php
session_start();

// Guest checkout is enabled, so no login redirect here

// Set up breadcrumb items
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Cart', 'url' => 'cart.php'],
    ['label' => 'Checkout', 'url' => null]
];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - LeatherForLocal</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'; ?>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #8f9125; border: none; border-radius: 15px;">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-check-circle-fill text-white mb-4" style="font-size: 5rem;"></i>
                    <h3 class="text-white fw-bold mb-3" style="font-size: 28px;">Đặt hàng thành công!</h3>
                    <p class="text-white mb-0" style="font-size: 18px; line-height: 1.6;">
                        Cảm ơn quý khách đã tin tưởng và chọn mua sản phẩm tại LeatherForLocal
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <?php include '../components/breadcrumb.php'; ?>
        <h1 class="cart-title mb-4">Thanh toán</h1>
    </div>

    <main class="container py-5">
        <div class="row">
            <!-- Checkout Form -->
            <div class="col-lg-8">
                <form id="checkoutForm" class="needs-validation" novalidate>
                    <!-- Personal Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Thông tin cá nhân</h3>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="fullName" class="form-label">Họ và tên</label>
                                    <input type="text" class="form-control" id="fullName" required>
                                    <div class="invalid-feedback">Vui lòng nhập họ tên của bạn.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                    <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Số điện thoại</label>
                                    <input type="tel" class="form-control" id="phone" required>
                                    <div class="invalid-feedback">Vui lòng nhập số điện thoại.</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Thông tin giao hàng</h3>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ giao hàng</label>
                                <textarea class="form-control" id="address" rows="3" required></textarea>
                                <div class="invalid-feedback">Vui lòng nhập địa chỉ giao hàng.</div>
                            </div>
                            <div class="mb-3">
                                <label for="deliveryMethod" class="form-label">Phương thức giao hàng</label>
                                <select class="form-select" id="deliveryMethod" required>
                                    <option value="">Chọn phương thức giao hàng...</option>
                                    <option value="standard">Giao hàng tiêu chuẩn (Miễn phí)</option>
                                </select>
                                <div class="invalid-feedback">Vui lòng chọn phương thức giao hàng.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Phương thức thanh toán</h3>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" required checked>
                                <label class="form-check-label" for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                </label>
                            </div>
                            <div class="invalid-feedback">Vui lòng chọn phương thức thanh toán.</div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary">
                    <h3 class="summary-title">Đơn hàng của bạn</h3>
                    <div id="cart-items-summary" class="summary-details">
                        <!-- Cart items will be dynamically populated here -->
                    </div>
                    <div class="summary-total">
                        <span>Tổng tiền:</span>
                        <span id="total-amount">0 VNĐ</span>
                    </div>
                    <p class="shipping-note">Tổng số tiền bạn phải trả bao gồm tất cả các loại phí hải quan hiện hành. Chúng tôi đảm bảo không có thêm bất kỳ khoản phí nào khi giao hàng</p>
                    <div class="input-group mb-3 mt-3">
                        <input type="text" class="form-control" id="couponCode" placeholder="Nhập mã giảm giá">
                        <button class="btn btn-outline-secondary" type="button" id="applyCouponBtn">Áp dụng</button>
                    </div>
                    <div id="couponMessage" class="small mb-3" style="display: none;"></div>
                    <button type="button" class="btn btn-primary w-100" id="placeOrderBtn">Đặt hàng</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php include '../components/footer.php'; ?>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Đang xử lý...</span>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Checkout JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            
            // Auto-fix prices that were saved without multiplying by 1000
            cart.forEach(item => {
                if (item.price < 10000) {
                    item.price = item.price * 1000;
                }
            });
            localStorage.setItem('cart', JSON.stringify(cart));
            const cartSummary = document.getElementById('cart-items-summary');
            const totalAmountElement = document.getElementById('total-amount');
            const checkoutForm = document.getElementById('checkoutForm');
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));

            let baseTotal = 0;
            let currentDiscount = 0;

            // Render cart summary
            function renderCartSummary() {
                baseTotal = 0;
                let summaryHTML = '';

                cart.forEach(item => {
                    const itemTotal = item.price * item.quantity;
                    baseTotal += itemTotal;
                    
                    summaryHTML += `
                        <div class="summary-item">
                            <span>${item.name} × ${item.quantity}</span>
                            <span>${itemTotal.toLocaleString('vi-VN')} VNĐ</span>
                        </div>
                    `;
                });

                cartSummary.innerHTML = summaryHTML;
                updateDisplayTotal();
            }

            function updateDisplayTotal() {
                const discountAmount = Math.floor(baseTotal * (currentDiscount / 100));
                const finalTotal = baseTotal - discountAmount;
                totalAmountElement.textContent = `${finalTotal.toLocaleString('vi-VN')} VNĐ`;
            }

            // Apply coupon logic
            document.getElementById('applyCouponBtn').addEventListener('click', async function() {
                const code = document.getElementById('couponCode').value.trim();
                const msgEl = document.getElementById('couponMessage');
                
                if (!code) {
                    alert('Vui lòng nhập mã giảm giá');
                    return;
                }

                try {
                    const response = await fetch('../../src/controllers/CouponController.php?action=apply', {
                        method: 'POST',
                        body: JSON.stringify({ code: code })
                    });
                    const result = await response.json();
                    
                    msgEl.style.display = 'block';
                    if (result.success) {
                        currentDiscount = result.discount_percentage;
                        msgEl.className = 'small mb-3 text-success';
                        msgEl.textContent = `Áp dụng thành công! Đã giảm ${currentDiscount}%`;
                        updateDisplayTotal();
                    } else {
                        currentDiscount = 0;
                        msgEl.className = 'small mb-3 text-danger';
                        msgEl.textContent = result.error;
                        updateDisplayTotal();
                    }
                } catch (e) {
                    console.error('Coupon error:', e);
                }
            });

            // Handle form submission
            placeOrderBtn.addEventListener('click', async function(e) {
                e.preventDefault();

                // Disable the button to prevent double submission
                placeOrderBtn.disabled = true;

                if (!checkoutForm.checkValidity()) {
                    checkoutForm.classList.add('was-validated');
                    placeOrderBtn.disabled = false;
                    return;
                }

                // Check if cart is empty
                if (!cart || cart.length === 0) {
                    alert('Giỏ hàng của bạn đang trống');
                    placeOrderBtn.disabled = false;
                    return;
                }

                // Validate payment method
                const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked');
                if (!selectedPaymentMethod) {
                    alert('Vui lòng chọn phương thức thanh toán');
                    placeOrderBtn.disabled = false;
                    return;
                }

                // Show loading overlay
                loadingOverlay.style.display = 'block';

                const formData = {
                    full_name: document.getElementById('fullName').value.trim(),
                    email: document.getElementById('email').value.trim(),
                    phone_number: document.getElementById('phone').value.trim(),
                    address: document.getElementById('address').value.trim(),
                    delivery_method: document.getElementById('deliveryMethod').value,
                    payment_method: selectedPaymentMethod.value,
                    coupon_code: document.getElementById('couponCode').value.trim(),
                    cart_items: cart.map(item => ({
                        id: item.id,
                        quantity: item.quantity,
                        price: item.price
                    }))
                };

                try {
                    const response = await fetch('../../src/controllers/CheckoutController.php?action=submit', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(formData)
                    });

                    const result = await response.json();

                    // Hide loading overlay
                    loadingOverlay.style.display = 'none';

                    if (result.success) {
                        // Clear cart only on actual success
                        localStorage.removeItem('cart');
                        
                        // Show success modal
                        successModal.show();
                        
                        // Redirect after 2 seconds
                        setTimeout(() => {
                            window.location.href = 'index.php';
                        }, 2000);
                    } else {
                        // Show the real error from the server
                        alert('Đặt hàng thất bại: ' + (result.error || 'Lỗi không xác định'));
                        placeOrderBtn.disabled = false;
                    }

                } catch (error) {
                    // Hide loading overlay and re-enable button
                    loadingOverlay.style.display = 'none';
                    placeOrderBtn.disabled = false;
                    alert('Đã xảy ra lỗi kết nối. Vui lòng thử lại.');
                    console.error('Checkout error:', error);
                }
            });

            // Initialize
            renderCartSummary();
        });
    </script>
</body>
</html> 