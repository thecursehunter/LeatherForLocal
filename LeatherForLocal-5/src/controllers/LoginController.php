<?php
require_once __DIR__ . '/../models/LoginModel.php';

class LoginController {
    private $loginModel;
    public function __construct() {
        $this->loginModel = new LoginModel();
    }
public function handleAdminLogin($username, $password) {
    return $this->loginModel->checkAdminLogin($username, $password);
}
    public function handleLogin($username, $password) {
        return $this->loginModel->checkLogin($username, $password);
    }
}