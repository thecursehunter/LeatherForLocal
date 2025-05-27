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
    // Get the product from our products array
    foreach ($this->products as $product) {
      if ($product['id'] == $id) {
        return $product;
      }
    }
    return null;
  }

  public function getRelatedProducts($currentProductId, $limit = 3) {
    // Filter out the current product and get related products
    $related = array_filter($this->products, function($product) use ($currentProductId) {
      return $product['id'] != $currentProductId;
    });
    
    // Shuffle and limit the results
    shuffle($related);
    return array_slice($related, 0, $limit);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'loadMore') {
  $controller = new ProductController();
  $controller->loadMoreProducts();
}
