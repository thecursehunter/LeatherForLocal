<?php
require_once __DIR__ . '/../models/RegisterModel.php';

class RegisterController {
    private $registerModel;
    public function __construct() {
        $this->registerModel = new RegisterModel();
    }
    public function handleRegister($username, $full_name, $email, $password, $phone_number, $address) {
        return $this->registerModel->register($username, $full_name, $email, $password, $phone_number, $address);
    }
}