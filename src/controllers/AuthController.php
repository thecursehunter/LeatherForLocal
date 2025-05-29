<?php
session_start();

class AuthController {
    public function handleRequest() {
        $action = $_GET['action'] ?? '';

        switch ($action) {
            case 'check_login':
                $this->checkLogin();
                break;
            default:
                echo json_encode(['success' => false, 'error' => 'Invalid action']);
                break;
        }
    }

    private function checkLogin() {
        header('Content-Type: application/json');
        
        // Check if user is logged in (member_id exists in session)
        $isLoggedIn = isset($_SESSION['member_id']);
        
        echo json_encode([
            'success' => true,
            'logged_in' => $isLoggedIn
        ]);
    }
}

// Initialize and handle request
$controller = new AuthController();
$controller->handleRequest(); 