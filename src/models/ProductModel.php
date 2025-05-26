<?php
class ProductModel {
  private $db;

  public function __construct() {
    $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
    if ($this->db->connect_error) {
      die('Database connection failed: ' . $this->db->connect_error);
    }
  }

  public function fetchProducts() {
    $result = $this->db->query('SELECT * FROM products LIMIT 10');
    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Kiểm tra nếu cột 'colors' tồn tại và không rỗng
        $row['colors'] = isset($row['colors']) ? explode(',', $row['colors']) : [];
        $products[] = $row;
    }
    return $products;
}

  public function fetchMoreProducts() {
    $result = $this->db->query('SELECT * FROM products LIMIT 10 OFFSET 10');
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['colors'] = isset($row['colors']) ? explode(',', $row['colors']) : [];
        $products[] = $row;
    }
    return $products;
}
}
