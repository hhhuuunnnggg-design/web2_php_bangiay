<?php
require_once __DIR__ . '/../../models/client/UserModel.php';
require_once __DIR__ . '/../../models/client/CartModel.php';

class AuthController
{
    private $userModel;
    private $cartModel;
    private $db;

    public function __construct($db)
    {
        $this->userModel = new UserModel();
        $this->cartModel = new CartModel($db);
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
            $matKhauCu = $_POST['matKhauCu'] ?? '';
            $matKhauMoi = $_POST['matKhauMoi'] ?? '';
            $matKhauXacNhan = $_POST['matKhauXacNhan'] ?? '';

            // Lấy thông tin người dùng hiện tại
            $userInfo = $this->userModel->getUserInfo($maKH);

            // Kiểm tra mật khẩu cũ
            if ($matKhauCu !== $userInfo['MatKhau']) {
                $error = "Mật khẩu cũ không đúng!";
            } elseif ($matKhauMoi !== $matKhauXacNhan) {
                $error = "Mật khẩu mới và xác nhận mật khẩu không khớp!";
            } elseif (strlen($matKhauMoi) < 6) {
                $error = "Mật khẩu mới phải có ít nhất 6 ký tự!";
            } elseif ($matKhauCu === $matKhauMoi) {
                $error = "Mật khẩu mới không được trùng với mật khẩu cũ!";
            } else {
                // Cập nhật thông tin người dùng với mật khẩu dạng plaintext
                if ($this->userModel->updateUser($maKH, $tenKH, $email, $sdt, $diaChi, $matKhauMoi)) {
                    // Cập nhật session
                    $_SESSION['user']['TenKH'] = $tenKH;
                    $_SESSION['user']['Email'] = $email;
                    $_SESSION['user']['SDT'] = $sdt;
                    $_SESSION['user']['DiaChi'] = $diaChi;
                    $_SESSION['user']['MatKhau'] = $matKhauMoi; // Cập nhật mật khẩu mới vào session
                    $success = "Cập nhật thông tin thành công!";
                } else {
                    $error = "Cập nhật thất bại, vui lòng thử lại!";
                }
            }

            // Lấy lại thông tin user để hiển thị
            $userInfo = $this->userModel->getUserInfo($maKH);
            $title = "Thông tin cá nhân";
            include __DIR__ . '/../../views/client/page/profile.php';
        }
    }

    // Đăng nhập
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
                if ($user['TrangThai'] != 0) {
                    // Tài khoản bị khóa
                    $error = "Tài khoản của bạn đã bị khóa.";
                    $title = "Đăng nhập";
                    include __DIR__ . '/../../views/client/page/login.php';
                    return; // dừng hàm ở đây
                }

                session_start();
                if (isset($_SESSION['user'])) {
                    $this->cartModel->clearCart($_SESSION['user']['MaKH']);
                }
                $_SESSION['user'] = $user;
                $_SESSION['cart_count'] = $this->cartModel->getCartCount($user['MaKH']);
                header("Location: /shoeimportsystem/index.php?controller=home&action=index");
                exit;
            } else {
                $error = "Email hoặc mật khẩu không đúng!";
                $title = "Đăng nhập";
                include __DIR__ . '/../../views/client/page/login.php';
            }
        }
    }


    // Đăng ký
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
            } elseif (strlen($matKhau) < 6) {
                $error = "Mật khẩu phải có ít nhất 6 ký tự!";
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

    // Đăng xuất
    public function logout()
    {
        session_start();
        unset($_SESSION['user']);
        unset($_SESSION['cart_count']);
        header("Location: /shoeimportsystem/index.php?controller=home&action=index");
        exit;
    }
}
