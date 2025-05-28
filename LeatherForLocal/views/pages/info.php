<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="/public/css/global.css" />
    <link rel="stylesheet" href="/public/css/styleguide.css" />
    <link rel="stylesheet" href="/public/css/info.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
  </head>
  <body>
    <div class="desktop-information">
      <div class="div">
        <div class="breadcrumbb">
          <div class="component"><div class="text">Giỏ hàng</div></div>
          <div class="component-2"><div class="text-wrapper">/</div></div>
          <div class="component"><div class="text ">Thông tin</div></div>
          <div class="component-2"><div class="text-wrapper">/</div></div>
          <div class="component"><div class="text">Vận chuyển</div></div>
          <div class="component-2"><div class="text-wrapper">/</div></div>
          <div class="component"><div class="text">Thanh toán</div></div>
        </div>

        <div class="frame-12">
          <div class="frame-13">
            <div class="contact">Thông tin liên hệ</div>
            <div class="frame-14">
              <div class="have-an-account">Đã có tài khoản?</div>
              <div class="log-in">Đăng nhập</div>
            </div>
          </div>
          <div class="input-orginal">
            <input type="email" placeholder="Email" required>
          </div>
        </div>

        <div class="shipping-address">Địa chỉ giao hàng</div>
        <div class="shipping-address-2">
          <div class="input-orginal">
            <div class="label">Quốc gia/Khu vực</div>
            <select required>
              <option value="VN">Việt Nam</option>
            </select>
          </div>
          <div class="frame-2">
            <div class="input-orginal-2">
              <input type="text" placeholder="Họ" required>
            </div>
            <div class="input-orginal-3">
              <input type="text" placeholder="Tên" required>
            </div>
          </div>
          <div class="input-orginal">
            <input type="text" placeholder="Công ty (tùy chọn)">
          </div>
          <div class="input-orginal">
            <input type="text" placeholder="Địa chỉ" required>
          </div>
          <div class="input-orginal">
            <input type="text" placeholder="Căn hộ, tòa nhà, v.v. (tùy chọn)">
          </div>
          <div class="frame-3">
            <div class="input-orginal-4">
              <input type="text" placeholder="Mã bưu điện" required>
            </div>
            <div class="input-orginal-4">
              <input type="text" placeholder="Thành phố" required>
            </div>
          </div>
          <div class="input-orginal">
            <input type="tel" placeholder="Số điện thoại" required>
          </div>
        </div>

        <div class="frame-4">
          <input type="checkbox" id="save-info">
          <label for="save-info">Lưu thông tin cho lần sau</label>
        </div>

        <div class="your-cart">
          <div class="cart-title">Giỏ hàng của bạn</div>
          <div id="cart-items">
            <!-- Cart items will be loaded here -->
          </div>
          <div class="cart-summary-row">
            <span>Tạm tính (<span id="total-items">0</span>)</span>
            <span id="subtotal">0 đ</span>
          </div>
          <div class="cart-summary-row">
            <span>Thuế</span>
            <span id="tax">0 đ</span>
          </div>
          <div class="cart-summary-row total">
            <span>Tổng đơn hàng:</span>
            <span id="total-amount">0 đ</span>
          </div>
          <div class="cart-summary-row">
            <span>Phí vận chuyển</span>
            <span>Miễn phí</span>
          </div>
        </div>

        <div class="frame-11">
          <div class="button-comp" id="return-cart">
           <img class="arrow-back-ios" src="/arrow_back.png" />
            <div class="add-to-cart">Quay lại giỏ hàng</div>
          </div>
          <div class="button-comp-2" id="continue-shipping"><div class="add-to-cart-2">Tiếp tục đến vận chuyển</div></div>
        </div>
      </div>
    </div>

    <div class="cart-icon-container">
      <span class="material-symbols-outlined" id="cart-icon">shopping_cart</span>
      <div class="shopping-bag-preview" id="shopping-bag-preview"></div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const cartItems = document.getElementById('cart-items');
        const totalItems = document.getElementById('total-items');
        const subtotal = document.getElementById('subtotal');
        const tax = document.getElementById('tax');
        const totalAmount = document.getElementById('total-amount');
        const returnCart = document.getElementById('return-cart');
        const continueShipping = document.getElementById('continue-shipping');
        const cartIcon = document.getElementById('cart-icon');
        const shoppingBagPreview = document.getElementById('shopping-bag-preview');

        // Load cart items from localStorage
        function loadCart() {
          const cart = JSON.parse(localStorage.getItem('cart')) || [];
          let total = 0;
          let itemsCount = 0;

          cartItems.innerHTML = cart.map(item => {
            const itemTotal = item.price * item.quantity;
            total += itemTotal;
            itemsCount += item.quantity;

            return `
              <div class="cart-item">
                <img class="cart-item-img" src="${item.image}" alt="${item.name}" />
                <div class="cart-item-info">
                  <div class="cart-item-name">${item.name}</div>
                  <div class="cart-item-details">Size: S | Màu: Đen</div>
                  <div class="cart-item-qty">Số lượng: <span>${item.quantity}</span></div>
                </div>
                <div class="cart-item-price">${item.price.toLocaleString('vi-VN')} đ</div>
              </div>
            `;
          }).join('');

          const taxAmount = total * 0.1; // 10% tax
          const finalTotal = total + taxAmount;

          totalItems.textContent = itemsCount;
          subtotal.textContent = `${total.toLocaleString('vi-VN')} đ`;
          tax.textContent = `${taxAmount.toLocaleString('vi-VN')} đ`;
          totalAmount.textContent = `${finalTotal.toLocaleString('vi-VN')} đ`;
        }

        // Load cart on page load
        loadCart();

        // Handle return to cart button click
        returnCart.addEventListener('click', function() {
          window.location.href = 'cart.html';
        });

        // Handle continue to shipping button click
        continueShipping.addEventListener('click', function() {
          // Validate form
          const requiredFields = document.querySelectorAll('input[required]');
          let isValid = true;

          requiredFields.forEach(field => {
            if (!field.value) {
              isValid = false;
              field.style.borderColor = 'red';
            } else {
              field.style.borderColor = '';
            }
          });

          if (isValid) {
            // Save shipping info to localStorage
            const shippingInfo = {
              email: document.querySelector('input[type="email"]').value,
              firstName: document.querySelector('.input-orginal-2 input').value,
              lastName: document.querySelector('.input-orginal-3 input').value,
              address: document.querySelector('.shipping-address-2 input[type="text"]').value,
              city: document.querySelector('.frame-3 .input-orginal-4:last-child input').value,
              postalCode: document.querySelector('.frame-3 .input-orginal-4:first-child input').value,
              phone: document.querySelector('input[type="tel"]').value
            };
            localStorage.setItem('shippingInfo', JSON.stringify(shippingInfo));
            
            // Proceed to payment
            window.location.href = 'payment.html';
          }
        });

        function renderShoppingBagPreview() {
          const cart = JSON.parse(localStorage.getItem('cart')) || [];
          // Only show Áo Da Nam Biker AM22
          const filtered = cart.filter(item => item.id === 'ao-da-nam-biker-am22');
          if (filtered.length === 0) {
            shoppingBagPreview.innerHTML = '<div class="empty-cart">Giỏ hàng của bạn đang trống.</div>';
            return;
          }
          shoppingBagPreview.innerHTML = filtered.map(item => `
            <div class="preview-item">
              <img src="${item.image}" alt="${item.name}">
              <div class="preview-info">
                <h4>${item.name}</h4>
                <p>${item.price.toLocaleString('vi-VN')} đ</p>
                <p>Số lượng: ${item.quantity}</p>
              </div>
            </div>
          `).join('') + `<a href="cart.html" class="view-cart-btn">Xem giỏ hàng</a>`;
        }

        cartIcon.addEventListener('mouseenter', function() {
          renderShoppingBagPreview();
          shoppingBagPreview.style.display = 'block';
        });
        cartIcon.addEventListener('mouseleave', function() {
          setTimeout(() => shoppingBagPreview.style.display = 'none', 200);
        });
        shoppingBagPreview.addEventListener('mouseenter', function() {
          shoppingBagPreview.style.display = 'block';
        });
        shoppingBagPreview.addEventListener('mouseleave', function() {
          shoppingBagPreview.style.display = 'none';
        });
      });
    </script>
    <style>
    .cart-icon-container { position: relative; display: inline-block; }
    .shopping-bag-preview {
      display: none;
      position: absolute;
      right: 0;
      top: 40px;
      width: 320px;
      background: #fff;
      border: 1px solid #e0e0e0;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
      z-index: 100;
      padding: 16px;
      border-radius: 8px;
    }
    .preview-item { display: flex; align-items: center; margin-bottom: 12px; }
    .preview-item img { width: 48px; height: 48px; object-fit: cover; border-radius: 4px; margin-right: 12px; }
    .preview-info h4 { margin: 0 0 4px 0; font-size: 15px; }
    .view-cart-btn { display: block; margin-top: 10px; text-align: center; background: #927830; color: #fff; padding: 8px 0; border-radius: 4px; text-decoration: none; }
    .your-cart {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 16px rgba(0,0,0,0.06);
      padding: 32px 24px;
      margin: 32px 0 0 0;
      max-width: 400px;
      min-width: 320px;
      font-family: 'Inter', Arial, sans-serif;
    }
    .cart-title {
      font-size: 1.3rem;
      font-weight: 700;
      color: #222;
      margin-bottom: 18px;
      letter-spacing: 0.5px;
    }
    .cart-item {
      display: flex;
      align-items: center;
      margin-bottom: 18px;
      border-bottom: 1px solid #eee;
      padding-bottom: 12px;
    }
    .cart-item-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 16px;
      border: 1px solid #eee;
    }
    .cart-item-info {
      flex: 1;
    }
    .cart-item-name {
      font-size: 1rem;
      font-weight: 600;
      color: #333;
      margin-bottom: 4px;
    }
    .cart-item-details {
      font-size: 0.95rem;
      color: #888;
      margin-bottom: 2px;
    }
    .cart-item-qty {
      font-size: 0.95rem;
      color: #555;
    }
    .cart-item-price {
      font-size: 1rem;
      font-weight: 500;
      color: #927830;
      margin-left: 12px;
    }
    .cart-summary-row {
      display: flex;
      justify-content: space-between;
      font-size: 1rem;
      margin: 8px 0;
      color: #444;
    }
    .cart-summary-row.total {
      font-weight: 700;
      color: #927830;
      font-size: 1.1rem;
      margin-top: 16px;
    }
    </style>
  </body>
</html>
