<?php
require_once(__DIR__ . '/../models/CartModel.php');
require_once(__DIR__ . '/../models/ProductModel.php');


class CartController {
    private $cartModel;
    private $productModel;


    public function __construct() {
        $this->cartModel = new CartModel();
        $this->productModel = new ProductModel();
    }


    /**
     * Add a product to the cart
     */
    public function addToCart($productId, $size, $color, $quantity) {
        // Input validation
        if (!$this->validateInput($productId, $size, $color, $quantity)) {
            return [
                'success' => false,
                'message' => 'Invalid input parameters'
            ];
        }


        // Get product details
        $product = $this->cartModel->getProductById($productId);
       
        if (!$product) {
            return [
                'success' => false,
                'message' => 'Product not found'
            ];
        }


        // Validate size
        $validSizes = ['S', 'M', 'L', 'XL', '2XL'];
        if (!in_array($size, $validSizes)) {
            return [
                'success' => false,
                'message' => 'Invalid size selected'
            ];
        }


        // Validate color exists in product colors
        $productColors = json_decode($product['colors'], true);
        if (!in_array($color, $productColors)) {
            return [
                'success' => false,
                'message' => 'Invalid color selected'
            ];
        }


        // Create cart item
        $cartItem = [
            'id' => (int)$product['id'],
            'name' => $product['name'],
            'price' => (float)$product['price'],
            'image' => $product['images'][0], // First image from the array
            'size' => $size,
            'color' => $color,
            'quantity' => (int)$quantity
        ];


        return [
            'success' => true,
            'product' => $cartItem
        ];
    }


    /**
     * Update quantity of a cart item
     */
    public function updateCartQuantity($productId, $quantity) {
        if (!$productId || !is_numeric($quantity) || $quantity < 1) {
            return [
                'success' => false,
                'message' => 'Invalid input parameters'
            ];
        }


        return [
            'success' => true,
            'productId' => (int)$productId,
            'quantity' => (int)$quantity
        ];
    }


    /**
     * Remove an item from the cart
     */
    public function removeFromCart($productId) {
        if (!$productId) {
            return [
                'success' => false,
                'message' => 'Invalid product ID'
            ];
        }


        return [
            'success' => true,
            'productId' => (int)$productId
        ];
    }


    /**
     * Get cart items by product IDs
     */
    public function getCartItems($productIds) {
        if (!is_array($productIds)) {
            return [
                'success' => false,
                'message' => 'Invalid product IDs'
            ];
        }


        $products = $this->cartModel->getProductsInCart($productIds);
        return [
            'success' => true,
            'products' => $products
        ];
    }


    /**
     * Validate input parameters
     */
    private function validateInput($productId, $size, $color, $quantity) {
        return (
            !empty($productId) &&
            !empty($size) &&
            !empty($color) &&
            is_numeric($quantity) &&
            $quantity > 0
        );
    }
}


// Handle AJAX requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CartController();
    $action = $_POST['action'] ?? '';
   
    header('Content-Type: application/json');
   
    switch ($action) {
        case 'add':
            $result = $controller->addToCart(
                $_POST['productId'] ?? '',
                $_POST['size'] ?? '',
                $_POST['color'] ?? '',
                $_POST['quantity'] ?? 1
            );
            echo json_encode($result);
            break;
           
        case 'update':
            $result = $controller->updateCartQuantity(
                $_POST['productId'] ?? '',
                $_POST['quantity'] ?? 1
            );
            echo json_encode($result);
            break;
           
        case 'remove':
            $result = $controller->removeFromCart($_POST['productId'] ?? '');
            echo json_encode($result);
            break;
           
        case 'get':
            $result = $controller->getCartItems($_POST['productIds'] ?? []);
            echo json_encode($result);
            break;
           
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
    }
}
?>
