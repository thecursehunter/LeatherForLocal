<?php
require_once __DIR__ . '/../models/ProductModel.php';

header('Content-Type: application/json');
$model = new ProductModel();
$products = $model->fetchProducts();
echo json_encode($products);