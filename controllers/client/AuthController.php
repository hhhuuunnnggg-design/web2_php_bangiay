<?php
require_once __DIR__ . '/../../models/client/UserModel.php';

class AuthController
{
    private $userModel;
    private $db;

    public function __construct($db)
    {
        $this->userModel = new UserModel();
        $this->db = $db;
    }

    // Hiển thị form đăng nhập
    public function login()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }
        $title = "Đăng nhập";
        include __DIR__ . '/../../views/client/login.php';
    }

    // Xử lý đăng nhập
    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $matKhau = $_POST['matKhau'] ?? '';

            $user = $this->userModel->login($email, $matKhau);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user; // Lưu thông tin người dùng vào session
                header("Location: /shoeimportsystem/index.php?controller=home&action=index");
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
                $title = "Đăng nhập";
                include __DIR__ . '/../../views/client/login.php';
            }
        }
    }

    // Hiển thị form đăng ký
    public function register()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }
        $title = "Đăng ký";
        include __DIR__ . '/../../views/client/register.php';
    }

    // Xử lý đăng ký
    public function doRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenKH = $_POST['tenKH'] ?? '';
            $email = $_POST['email'] ?? '';
            $sdt = $_POST['sdt'] ?? '';
            $diaChi = $_POST['diaChi'] ?? '';
            $matKhau = $_POST['matKhau'] ?? '';

            if ($this->userModel->emailExists($email)) {
                $error = "Email đã được sử dụng!";
                $title = "Đăng ký";
                include __DIR__ . '/../../views/client/register.php';
            } else {
                if ($this->userModel->register($tenKH, $email, $sdt, $diaChi, $matKhau)) {
                    header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
                    exit;
                } else {
                    $error = "Đăng ký thất bại, vui lòng thử lại!";
                    $title = "Đăng ký";
                    include __DIR__ . '/../../views/client/register.php';
                }
            }
        }
    }

    // Đăng xuất
    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        header("Location: /shoeimportsystem/index.php?controller=home&action=index");
        exit;
    }
}
