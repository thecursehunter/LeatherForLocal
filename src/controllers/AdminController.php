<?php
require_once __DIR__ . '/../models/AdminModel.php';

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    public function listAdmins() {
        return $this->adminModel->getAllAdmins();
    }

    public function getAdmin($admin_id) {
        return $this->adminModel->getAdminById($admin_id);
    }

    public function createAdmin($username, $email, $password, $full_name) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->adminModel->addAdmin($username, $email, $password_hash, $full_name);
    }

    public function updateAdmin($admin_id, $username, $email, $full_name) {
        return $this->adminModel->updateAdmin($admin_id, $username, $email, $full_name);
    }

    public function deleteAdmin($admin_id) {
        return $this->adminModel->deleteAdmin($admin_id);
    }
}

// Example usage for handling requests (for demonstration, not production-ready)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AdminController();
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $controller->createAdmin($_POST['username'], $_POST['email'], $_POST['password'], $_POST['full_name']);
                break;
            case 'update':
                $controller->updateAdmin($_POST['admin_id'], $_POST['username'], $_POST['email'], $_POST['full_name']);
                break;
            case 'delete':
                $controller->deleteAdmin($_POST['admin_id']);
                break;
        }
        header('Location: ../../views/pages/admin.php');
        exit;
    }
}