<?php
require_once __DIR__ . '/../models/RegisterModel.php';

class RegisterController {
    private $registerModel;
    public function __construct() {
        $this->registerModel = new RegisterModel();
    }
    public function handleRegister($first_name, $last_name, $email, $password) {
        return $this->registerModel->register($first_name, $last_name, $email, $password);
    }
}