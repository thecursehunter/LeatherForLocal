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
        // Process colors
        $row['colors'] = isset($row['colors']) ? explode(',', $row['colors']) : [];
        
        // Process images
        $row['images'] = isset($row['images']) ? explode(',', $row['images']) : [];
        
        // Process features
        $row['features'] = isset($row['features']) ? explode(',', $row['features']) : [];
        
        // Ensure all required fields exist
        $row['material'] = $row['material'] ?? 'Leather';
        $row['material_description'] = $row['material_description'] ?? 'High-quality leather material';
        $row['category'] = $row['category'] ?? 'Accessories';
        
        $products[] = $row;
    }
    return $products;
}

  public function fetchMoreProducts() {
    $result = $this->db->query('SELECT * FROM products LIMIT 10 OFFSET 10');
    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Process colors
        $row['colors'] = isset($row['colors']) ? explode(',', $row['colors']) : [];
        
        // Process images
        $row['images'] = isset($row['images']) ? explode(',', $row['images']) : [];
        
        // Process features
        $row['features'] = isset($row['features']) ? explode(',', $row['features']) : [];
        
        // Ensure all required fields exist
        $row['material'] = $row['material'] ?? 'Leather';
        $row['material_description'] = $row['material_description'] ?? 'High-quality leather material';
        $row['category'] = $row['category'] ?? 'Accessories';
        
        $products[] = $row;
    }
    return $products;
}

public function getProductById($id) {
  $stmt = $this->db->prepare("SELECT * FROM tbl_products WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  if ($product) {
      // Process data giống fetchProducts()
      $product['colors'] = isset($product['colors']) ? explode(',', $product['colors']) : [];
      $product['images'] = isset($product['images']) ? explode(',', $product['images']) : [];
      $product['features'] = isset($product['features']) ? explode(',', $product['features']) : [];

      $product['material'] = $product['material'] ?? 'Leather';
      $product['material_description'] = $product['material_description'] ?? 'High-quality leather material';
      $product['category'] = $product['category'] ?? 'Accessories';
  }

  return $product;
}

}
