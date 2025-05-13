<?php
require_once '../../src/models/ProductModel.php';

class ProductController {
  private $productModel;

  public function __construct() {
    $this->productModel = new ProductModel();
  }

  public function getProducts() {
    return $this->productModel->fetchProducts();
  }

  public function loadMoreProducts() {
    header('Content-Type: application/json');
    echo json_encode(['products' => $this->productModel->fetchMoreProducts()]);
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'loadMore') {
  $controller = new ProductController();
  $controller->loadMoreProducts();
}
