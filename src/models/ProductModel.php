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
  $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $result = $stmt->get_result();
  $product = $result->fetch_assoc();

  if ($product) {
      // Process data similar to fetchProducts()
      $product['colors'] = isset($product['colors']) ? explode(',', $product['colors']) : [];
      $product['images'] = isset($product['images']) ? explode(',', $product['images']) : [];
      $product['features'] = isset($product['features']) ? explode(',', $product['features']) : [];

      // Ensure all required fields exist
      $product['material'] = $product['material'] ?? 'Leather';
      $product['material_description'] = $product['material_description'] ?? 'High-quality leather material';
      $product['category'] = $product['category'] ?? 'Accessories';
  }

  return $product;
}

public function getColors() {
    $result = $this->db->query('SELECT colors FROM products');
    $colorSet = [];
    while ($row = $result->fetch_assoc()) {
        $colors = explode(',', $row['colors']);
        foreach ($colors as $color) {
            $color = trim($color);
            if ($color && !in_array($color, $colorSet)) {
                $colorSet[] = $color;
            }
        }
    }
    return $colorSet;
}

public function getCategories() {
    $result = $this->db->query('SELECT * FROM category WHERE is_active = 1');
    return $result->fetch_all(MYSQLI_ASSOC);
}

public function getFilteredProducts($categoryIds = [], $colors = [], $sort = 'az') {
    $sql = 'SELECT * FROM products WHERE 1=1';
    $params = [];
    $types = '';
    if (!empty($categoryIds)) {
        $in = implode(',', array_fill(0, count($categoryIds), '?'));
        $sql .= " AND category_id IN ($in)";
        $types .= str_repeat('i', count($categoryIds));
        $params = array_merge($params, $categoryIds);
    }
    if (!empty($colors)) {
        $colorClauses = [];
        foreach ($colors as $color) {
            $colorClauses[] = "FIND_IN_SET(?, colors)";
            $types .= 's';
            $params[] = $color;
        }
        $sql .= " AND (" . implode(' OR ', $colorClauses) . ")";
    }
    // Sorting
    if ($sort === 'az') {
        $sql .= ' ORDER BY product_name ASC';
    } elseif ($sort === 'za') {
        $sql .= ' ORDER BY product_name DESC';
    }
    $stmt = $this->db->prepare($sql);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $row['colors'] = isset($row['colors']) ? explode(',', $row['colors']) : [];
        $row['images'] = isset($row['images']) ? explode(',', $row['images']) : [];
        $products[] = $row;
    }
    return $products;
}

}
