<?php
require_once('../../src/models/ProductModel.php');
require_once('../../src/models/CartModel.php');
$productModel = new ProductModel();
$cartModel = new CartModel();


// Set up breadcrumb items
$breadcrumb_items = [
    ['label' => 'Home', 'url' => 'index.php'],
    ['label' => 'Giỏ hàng của bạn', 'url' => null]
];
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - LeatherForLocal</title>
   
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
        <h1 class="cart-title mb-4">Giỏ hàng của bạn</h1>
    </div>


    <main>
        <div class="container cart-section py-5">
            <div class="row">
                <div class="col-lg-8">
                    <div class="cart-items">
                        <!-- Cart items will be dynamically populated here -->
                        <div id="cart-items-container"></div>
                    </div>
                </div>
               
                <div class="col-lg-4">
                    <div class="order-summary">
                        <h3 class="summary-title">Đơn hàng của bạn</h3>
                        <div class="summary-details">
                            <div class="summary-item">
                                <span>Tổng sản phẩm</span>
                                <span id="total-items">0 sp</span>
                            </div>
                            <div class="summary-item">
                                <span>Phí vận chuyển</span>
                                <span>Miễn phí</span>
                            </div>
                            <div class="summary-total">
                                <span>Tổng tiền:</span>
                                <span id="total-amount">0 VNĐ</span>
                            </div>
                        </div>
                        <p class="shipping-note">Tổng số tiền bạn phải trả bao gồm tất cả các loại phí hải quan hiện hành. Chúng tôi đảm bảo không có thêm bất kỳ khoản phí nào khi giao hàng</p>
                        <button class="btn btn-primary w-100 mb-2" id="checkout-btn">Tiến hành thanh toán</button>
                        <button class="btn btn-outline-secondary w-100" id="continue-shopping-btn">Tiếp tục mua hàng</button>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Footer -->
    <?php include '../components/footer.php'; ?>


    <!-- Cart Item Template -->
    <template id="cart-item-template">
        <div class="cart-item" data-product-id="">
            <div class="row align-items-center">
                <div class="col-3">
                    <img src="" alt="" class="img-fluid product-image">
                </div>
                <div class="col-6">
                    <h3 class="item-title"></h3>
                    <div class="item-details">
                        <span class="size"></span>
                        <span class="color"></span>
                    </div>
                    <div class="quantity-controls mt-2">
                        <button class="btn btn-outline-secondary btn-sm decrease-qty">-</button>
                        <span class="mx-2 quantity">1</span>
                        <button class="btn btn-outline-secondary btn-sm increase-qty">+</button>
                    </div>
                </div>
                <div class="col-2">
                    <div class="price"></div>
                </div>
                <div class="col-1">
                    <button class="btn-remove">×</button>
                </div>
            </div>
        </div>
    </template>


    <!-- Empty Cart Template -->
    <template id="empty-cart-template">
        <div class="empty-cart text-center py-5">
            <div class="empty-cart-icon mb-4">
                <i class="bi bi-cart-x" style="font-size: 3rem;"></i>
            </div>
            <h3 class="mb-3">Giỏ hàng của bạn hiện chưa có sản phẩm nào</h3>
            <p class="text-muted mb-4">Hãy khám phá sản phẩm của chúng tôi và chọn những ưu đãi tốt nhất!</p>
        </div>
    </template>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
   
    <!-- Cart JavaScript -->
    <script>
        class Cart {
            constructor() {
                this.items = JSON.parse(localStorage.getItem('cart')) || [];
                this.init();
            }


            init() {
                this.renderCart();
                this.attachEventListeners();
               
                // Add event listener for continue shopping button
                document.getElementById('continue-shopping-btn').addEventListener('click', () => {
                    window.location.href = 'product.php';
                });

                // Add event listener for checkout button
                document.getElementById('checkout-btn').addEventListener('click', () => {
                    this.handleCheckout();
                });
            }


            handleCheckout() {
                // Check if user is logged in
                fetch('../../src/controllers/AuthController.php?action=check_login')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        // If logged in, redirect to checkout page
                        window.location.href = 'checkout.php';
                    } else {
                        // If not logged in, show message
                        alert('Bạn cần đăng nhập trước khi thanh toán');
                        // Redirect to login page
                        window.location.href = 'login.php?redirect=checkout.php';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Đã xảy ra lỗi. Vui lòng thử lại sau.');
                });
            }


            attachEventListeners() {
                document.addEventListener('click', (e) => {
                    if (e.target.matches('.increase-qty')) {
                        const productId = e.target.closest('.cart-item').dataset.productId;
                        this.updateQuantity(productId, 1);
                    } else if (e.target.matches('.decrease-qty')) {
                        const productId = e.target.closest('.cart-item').dataset.productId;
                        this.updateQuantity(productId, -1);
                    } else if (e.target.matches('.btn-remove')) {
                        const productId = e.target.closest('.cart-item').dataset.productId;
                        this.removeItem(productId);
                    }
                });
            }


            addItem(product) {
                const existingItem = this.items.find(item =>
                    item.id === product.id &&
                    item.size === product.size &&
                    item.color === product.color
                );


                if (existingItem) {
                    existingItem.quantity += product.quantity;
                } else {
                    this.items.push(product);
                }


                this.saveCart();
                this.renderCart();
            }


            updateQuantity(productId, change) {
                const item = this.items.find(item => item.id === parseInt(productId));
                if (item) {
                    item.quantity = Math.max(1, item.quantity + change);
                    this.saveCart();
                    this.renderCart();
                }
            }


            removeItem(productId) {
                this.items = this.items.filter(item => item.id !== parseInt(productId));
                this.saveCart();
                this.renderCart();
            }


            saveCart() {
                localStorage.setItem('cart', JSON.stringify(this.items));
            }


            renderCart() {
                const container = document.getElementById('cart-items-container');
                container.innerHTML = '';


                if (this.items.length === 0) {
                    // Show empty cart message
                    const emptyTemplate = document.getElementById('empty-cart-template');
                    container.appendChild(emptyTemplate.content.cloneNode(true));
                   
                    // Update summary
                    document.getElementById('total-items').textContent = '0 sp';
                    document.getElementById('total-amount').textContent = '0 VNĐ';
                    return;
                }


                const template = document.getElementById('cart-item-template');
                let totalItems = 0;
                let totalAmount = 0;


                this.items.forEach(item => {
                    const cartItem = template.content.cloneNode(true);
                    const itemElement = cartItem.querySelector('.cart-item');
                   
                    itemElement.dataset.productId = item.id;
                    itemElement.querySelector('.product-image').src = item.image;
                    itemElement.querySelector('.product-image').alt = item.name;
                    itemElement.querySelector('.item-title').textContent = item.name;
                    itemElement.querySelector('.size').textContent = `Size: ${item.size}`;
                    itemElement.querySelector('.color').textContent = `Color: ${item.color}`;
                    itemElement.querySelector('.quantity').textContent = item.quantity;
                    itemElement.querySelector('.price').textContent = `${(item.price * item.quantity).toLocaleString('vi-VN')} VNĐ`;


                    container.appendChild(cartItem);


                    totalItems += item.quantity;
                    totalAmount += item.price * item.quantity;
                });


                document.getElementById('total-items').textContent = `${totalItems} sp`;
                document.getElementById('total-amount').textContent = `${totalAmount.toLocaleString('vi-VN')} VNĐ`;
            }
        }


        // Initialize cart
        const cart = new Cart();


        // Add to cart function (to be called from product details page)
        function addToCart(product) {
            fetch('../../src/controllers/CartController.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    action: 'add',
                    productId: product.id,
                    size: product.size,
                    color: product.color,
                    quantity: product.quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cart.addItem(data.product);
                }
            })
            .catch(error => console.error('Error:', error));
        }
    </script>
</body>
</html>
