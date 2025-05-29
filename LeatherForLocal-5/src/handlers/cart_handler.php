<?php
require_once('../models/CartModel.php');


header('Content-Type: application/json');


$cartModel = new CartModel();
$action = $_POST['action'] ?? '';


switch ($action) {
    case 'add':
        $productId = $_POST['productId'] ?? '';
        $size = $_POST['size'] ?? '';
        $color = $_POST['color'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;
       
        $product = $cartModel->getProductById($productId);
        if ($product) {
            $cartItem = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image' => $product['images'], // Assuming first image
                'size' => $size,
                'color' => $color,
                'quantity' => $quantity
            ];
            echo json_encode(['success' => true, 'product' => $cartItem]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found']);
        }
        break;


    case 'update':
        $productId = $_POST['productId'] ?? '';
        $quantity = $_POST['quantity'] ?? 1;
        echo json_encode(['success' => true, 'productId' => $productId, 'quantity' => $quantity]);
        break;


    case 'remove':
        $productId = $_POST['productId'] ?? '';
        echo json_encode(['success' => true, 'productId' => $productId]);
        break;


    case 'get':
        $productIds = $_POST['productIds'] ?? [];
        $products = $cartModel->getProductsInCart($productIds);
        echo json_encode(['success' => true, 'products' => $products]);
        break;


    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        break;
}
?>
