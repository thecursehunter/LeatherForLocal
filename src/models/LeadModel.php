<?php
require_once(__DIR__ . '/../config/Database.php');

class LeadModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function createLead($fullName, $email, $phone, $utmSource = null) {
        try {
            // First check if email or phone already exists
            $checkSql = "SELECT id FROM leads WHERE email = ? OR phone = ?";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bind_param("ss", $email, $phone);
            $checkStmt->execute();
            $result = $checkStmt->get_result();

            if ($result->num_rows > 0) {
                // Lead exists, return the existing ID and maybe update utm_source?
                $row = $result->fetch_assoc();
                $id = $row['id'];
                
                // Update utm_source and full_name if necessary
                $updateSql = "UPDATE leads SET full_name = ?, utm_source = ? WHERE id = ?";
                $upStmt = $this->db->prepare($updateSql);
                $upStmt->bind_param("ssi", $fullName, $utmSource, $id);
                $upStmt->execute();
                
                return $id;
            }

            // Lead doesn't exist, insert new
            $sql = "INSERT INTO leads (full_name, email, phone, utm_source, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            
            if (!$stmt) {
                error_log("Prepare failed in LeadModel: " . $this->db->error);
                return false;
            }

            $stmt->bind_param("ssss", $fullName, $email, $phone, $utmSource);

            if (!$stmt->execute()) {
                error_log("Execute failed in LeadModel: " . $stmt->error);
                return false;
            }

            return $stmt->insert_id;
        } catch (Exception $e) {
            error_log("Lead creation error: " . $e->getMessage());
            return false;
        }
    }
}
?>
