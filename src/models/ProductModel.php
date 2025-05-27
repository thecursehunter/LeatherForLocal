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
    $result = $this->db->query('SELECT * FROM tbl_products LIMIT 10');
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
    $result = $this->db->query('SELECT * FROM tbl_products LIMIT 10 OFFSET 10');
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
}
