<?php
require_once __DIR__ . '/../models/MemberModel.php';
session_start();

class CustomerInfoController {
    private $model;
    private $member_id;

    public function __construct() {
        $this->model = new MemberModel();
        $this->member_id = $_SESSION['member_id'] ?? null;
    }

    public function handleRequest() {
        if (!$this->member_id) {
            header('Location: login.php');
            exit;
        }

        // Handle AJAX update for email/phone
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'], $_POST['field'], $_POST['value'])) {
            $field = $_POST['field'];
            $value = $_POST['value'];
            $success = $this->model->updateField($this->member_id, $field, $value);
            echo json_encode(['success' => $success]);
            exit;
        }

        // Handle full form submit for other fields
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['full_name'], $_POST['address'])) {
            $data = [
                'username' => $_POST['username'],
                'full_name' => $_POST['full_name'],
                'address' => $_POST['address']
            ];
            $this->model->updateMember($this->member_id, $data);
            header('Location: customerinfo.php?success=1');
            exit;
        }

        // Load member data for the view
        $member = $this->model->getMemberById($this->member_id);
        return $member;
    }
} 