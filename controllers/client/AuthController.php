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

    // Hiển thị trang thông tin cá nhân
    public function profile()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }

        $userInfo = $this->userModel->getUserInfo($_SESSION['user']['MaKH']);
        $title = "Thông tin cá nhân";
        include __DIR__ . '/../../views/client/page/profile.php';
    }

    // Xử lý cập nhật thông tin cá nhân
    public function updateProfile()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKH = $_SESSION['user']['MaKH'];
            $tenKH = $_POST['tenKH'] ?? '';
            $email = $_POST['email'] ?? '';
            $sdt = $_POST['sdt'] ?? '';
            $diaChi = $_POST['diaChi'] ?? '';
            $matKhau = $_POST['matKhau'] ?? '';

            if ($this->userModel->updateUser($maKH, $tenKH, $email, $sdt, $diaChi, $matKhau)) {
                // Cập nhật lại session nếu cần
                $_SESSION['user']['TenKH'] = $tenKH;
                $success = "Cập nhật thông tin thành công!";
            } else {
                $error = "Cập nhật thất bại, vui lòng thử lại!";
            }

            $userInfo = $this->userModel->getUserInfo($maKH);
            $title = "Thông tin cá nhân";
            include __DIR__ . '/../../views/client/page/profile.php';
        }
    }

    // Các hàm khác giữ nguyên: login(), doLogin(), register(), doRegister(), logout()
    public function login()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }
        $title = "Đăng nhập";
        include __DIR__ . '/../../views/client/page/login.php';
    }

    public function doLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $matKhau = $_POST['matKhau'] ?? '';

            $user = $this->userModel->login($email, $matKhau);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: /shoeimportsystem/index.php?controller=home&action=index");
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
                $title = "Đăng nhập";
                include __DIR__ . '/../../views/client/page/login.php';
            }
        }
    }

    public function register()
    {
        if (isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }
        $title = "Đăng ký";
        include __DIR__ . '/../../views/client/page/register.php';
    }

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
                include __DIR__ . '/../../views/client/page/register.php';
            } else {
                if ($this->userModel->register($tenKH, $email, $sdt, $diaChi, $matKhau)) {
                    header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
                    exit;
                } else {
                    $error = "Đăng ký thất bại, vui lòng thử lại!";
                    $title = "Đăng ký";
                    include __DIR__ . '/../../views/client/page/register.php';
                }
            }
        }
    }

    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        header("Location: /shoeimportsystem/index.php?controller=home&action=index");
        exit;
    }
}
