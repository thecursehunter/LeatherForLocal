// Test data for cart items
const testCartItems = [
    {
        id: 1,
        name: "Balo Hành Trình",
        price: 380000.00,
        quantity: 1,
        color: "orange",
        size: "M"
    },
    {
        id: 2,
        name: "Balo Thành Thị",
        price: 450000.00,
        quantity: 2,
        color: "black",
        size: "L"
    }
];

// Test data for checkout form
const testCheckoutData = {
    full_name: "John Doe",
    email: "john.doe@example.com",
    phone_number: "1234567890",
    address: "123 Test Street, Test City",
    delivery_method: "standard",
    payment_method: "cod"
};

class CheckoutTester {
    constructor() {
        this.setupCart();
        this.attachTestControls();
    }

    setupCart() {
        // Store test items in localStorage
        localStorage.setItem('cart', JSON.stringify(testCartItems));
        console.log('Test cart items stored in localStorage');
    }

    attachTestControls() {
        // Create test control panel
        const controlPanel = document.createElement('div');
        controlPanel.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 9999;
        `;

        controlPanel.innerHTML = `
            <h5>Checkout Tester</h5>
            <button id="fillFormBtn" class="btn btn-primary btn-sm mb-2">Fill Form</button>
            <button id="submitFormBtn" class="btn btn-success btn-sm mb-2">Submit Form</button>
            <button id="clearCartBtn" class="btn btn-danger btn-sm">Clear Cart</button>
        `;

        document.body.appendChild(controlPanel);

        // Attach event listeners
        document.getElementById('fillFormBtn').addEventListener('click', () => this.fillForm());
        document.getElementById('submitFormBtn').addEventListener('click', () => this.submitForm());
        document.getElementById('clearCartBtn').addEventListener('click', () => this.clearCart());
    }

    fillForm() {
        try {
            // Fill personal information
            document.getElementById('fullName').value = testCheckoutData.full_name;
            document.getElementById('email').value = testCheckoutData.email;
            document.getElementById('phone').value = testCheckoutData.phone_number;
            document.getElementById('address').value = testCheckoutData.address;
            
            // Select delivery method
            document.getElementById('deliveryMethod').value = testCheckoutData.delivery_method;
            
            // Select payment method
            document.querySelector(`input[name="paymentMethod"][value="${testCheckoutData.payment_method}"]`).checked = true;

            // Trigger form validation
            document.getElementById('checkoutForm').classList.add('was-validated');
            
            console.log('Form filled with test data');
        } catch (error) {
            console.error('Error filling form:', error);
        }
    }

    submitForm() {
        try {
            // Trigger the place order button click
            document.getElementById('placeOrderBtn').click();
            console.log('Form submission triggered');
        } catch (error) {
            console.error('Error submitting form:', error);
        }
    }

    clearCart() {
        localStorage.removeItem('cart');
        console.log('Cart cleared');
        window.location.reload();
    }

    // Helper method to validate the checkout process
    validateCheckoutProcess() {
        // Check if cart exists
        const cart = JSON.parse(localStorage.getItem('cart'));
        if (!cart || cart.length === 0) {
            console.error('Cart is empty');
            return false;
        }

        // Check if form is filled correctly
        const form = document.getElementById('checkoutForm');
        if (!form.checkValidity()) {
            console.error('Form is not valid');
            return false;
        }

        return true;
    }
}

// Initialize tester when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('Initializing checkout tester...');
    window.checkoutTester = new CheckoutTester();
}); 