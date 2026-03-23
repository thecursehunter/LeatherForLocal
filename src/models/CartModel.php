<?php
require_once __DIR__ . '/../config/Database.php';

class CartModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }


    public function getProductById($productId) {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function getProductsInCart($productIds) {
        if (empty($productIds)) {
            return [];
        }
       
        $ids = implode(',', array_map('intval', $productIds));
        $query = "SELECT * FROM products WHERE product_id IN ($ids)";
        $result = $this->db->query($query);
       
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
}
?>
