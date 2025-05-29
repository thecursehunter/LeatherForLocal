<?php
require_once '../../src/models/ProductModel.php';

class ProductController {
  private $productModel;
  private $products;

  public function __construct() {
    $this->productModel = new ProductModel();
    $this->products = $this->productModel->fetchProducts();
  }

  public function getProducts() {
    return $this->products;
  }

  public function loadMoreProducts() {
    header('Content-Type: application/json');
    echo json_encode(['products' => $this->productModel->fetchMoreProducts()]);
  }

  public function getProductById($id) {
    // Get the product from the database using the model
    $product = $this->productModel->getProductById($id);
    if (!$product) {
      return null;
    }
    return $product;
  }

  public function getRelatedProducts($currentProductId, $limit = 3) {
    // Get all products except the current one
    $allProducts = $this->products;
    $related = array_filter($allProducts, function($product) use ($currentProductId) {
      return $product['product_id'] != $currentProductId;
    });
    
    // Shuffle and limit the results
    shuffle($related);
    return array_slice($related, 0, $limit);
  }

  public function getColors() {
    return $this->productModel->getColors();
  }

  public function getCategories() {
    return $this->productModel->getCategories();
  }

  public function getFilteredProducts($categoryIds = [], $colors = [], $sort = 'az') {
    return $this->productModel->getFilteredProducts($categoryIds, $colors, $sort);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'loadMore') {
  $controller = new ProductController();
  $controller->loadMoreProducts();
}

// AJAX endpoint for category and color filtering
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'filterProducts') {
    $categories = isset($_POST['categories']) ? $_POST['categories'] : [];
    $colors = isset($_POST['colors']) ? $_POST['colors'] : [];
    $sort = isset($_POST['sort']) ? $_POST['sort'] : 'az';
    $controller = new ProductController();
    $products = $controller->getFilteredProducts($categories, $colors, $sort);
    echo json_encode(['products' => $products]);
    exit;
}
