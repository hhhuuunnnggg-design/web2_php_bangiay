<?php
require_once __DIR__ . '/../core/Auth.php';

class AuthController {
    private $auth;

    public function __construct() {
        $this->auth = new Auth();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if ($this->auth->login($email, $password)) {
                header("Location: /shoeimportsystem/public/index.php?controller=category&action=index");
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng.";
            }
        }
        include __DIR__ . '/../views/auth/login.php';
    }

    public function logout() {
        $this->auth->logout();
        header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
        exit;
    }
}