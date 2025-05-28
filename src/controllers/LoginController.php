<?php
require_once __DIR__ . '/../models/LoginModel.php';

class LoginController {
    private $loginModel;
    public function __construct() {
        $this->loginModel = new LoginModel();
    }
    public function handleLogin($email, $password) {
        return $this->loginModel->checkLogin($email, $password);
    }
}