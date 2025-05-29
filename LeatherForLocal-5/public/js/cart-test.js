// Test Data
const testProducts = [
    {
        id: 1,
        name: "Classic Leather Wallet",
        price: 599000,
        quantity: 2,
        image: "/public/images/products/wallet.jpg",
        color: "Brown",
        size: "Standard"
    },
    {
        id: 2,
        name: "Premium Leather Belt",
        price: 799000,
        quantity: 1,
        image: "/public/images/products/belt.jpg",
        color: "Black",
        size: "36"
    }
];

// Test Functions
const CartTest = {
    // Load sample data
    loadSampleData: function() {
        localStorage.setItem('cart', JSON.stringify(testProducts));
        this.refreshPage();
    },

    // Clear cart
    clearCart: function() {
        localStorage.removeItem('cart');
        this.refreshPage();
    },

    // Add single item
    addSingleItem: function() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const newItem = {
            id: Date.now(),
            name: "Test Product",
            price: 299000,
            quantity: 1,
            image: "/public/images/products/default.jpg",
            color: "Black",
            size: "M"
        };
        cart.push(newItem);
        localStorage.setItem('cart', JSON.stringify(cart));
        this.refreshPage();
    },

    // Modify quantity
    modifyQuantity: function(index, change) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart[index]) {
            cart[index].quantity = Math.max(1, cart[index].quantity + change);
            localStorage.setItem('cart', JSON.stringify(cart));
            this.refreshPage();
        }
    },

    // Remove item
    removeItem: function(index) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart[index]) {
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            this.refreshPage();
        }
    },

    // Refresh page
    refreshPage: function() {
        window.location.reload();
    },

    // Add test panel to page
    addTestPanel: function() {
        const panel = document.createElement('div');
        panel.className = 'cart-test-panel';
        panel.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 1000;
        `;

        panel.innerHTML = `
            <h5 style="margin-bottom: 10px;">Cart Test Panel</h5>
            <div style="display: grid; gap: 5px;">
                <button onclick="CartTest.loadSampleData()" class="btn btn-primary btn-sm">Load Sample Data</button>
                <button onclick="CartTest.clearCart()" class="btn btn-danger btn-sm">Clear Cart</button>
                <button onclick="CartTest.addSingleItem()" class="btn btn-success btn-sm">Add Test Item</button>
                <div class="btn-group btn-group-sm">
                    <button onclick="CartTest.modifyQuantity(0, 1)" class="btn btn-secondary">+1 First Item</button>
                    <button onclick="CartTest.modifyQuantity(0, -1)" class="btn btn-secondary">-1 First Item</button>
                </div>
                <button onclick="CartTest.removeItem(0)" class="btn btn-warning btn-sm">Remove First Item</button>
            </div>
        `;

        document.body.appendChild(panel);
    }
};

// Initialize test panel when in development
if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
    document.addEventListener('DOMContentLoaded', function() {
        CartTest.addTestPanel();
    });
} 