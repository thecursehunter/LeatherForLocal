<?php
class CartModel {
    private $db;


    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'leatherforlocal');
        if ($this->db->connect_error) {
            die('Database connection failed: ' . $this->db->connect_error);
        }
    }


    public function getProductById($productId) {
        $stmt = $this->db->prepare("SELECT * FROM tbl_products WHERE id = ?");
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
        $query = "SELECT * FROM tbl_products WHERE id IN ($ids)";
        $result = $this->db->query($query);
       
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return $products;
    }
}
?>
