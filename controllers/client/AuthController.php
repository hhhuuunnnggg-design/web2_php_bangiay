<?php
require_once __DIR__ . '/../../models/client/UserModel.php';

class AuthController
{
    private $userModel;
    private $db;

   public function __construct() {
        $this->auth = new Auth();
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=naruto", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối CSDL: " . $e->getMessage());
        }
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

    public function register() {
        $error = "";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tenNV = $_POST['tenNV'];
            $email = $_POST['email'];
            $sdt = $_POST['sdt'];
            $diaChi = $_POST['diaChi'];
            $matKhau = $_POST['matKhau'];
            $confirmMatKhau = $_POST['confirmMatKhau'];
    
            if ($matKhau !== $confirmMatKhau) {
                $error = "Mật khẩu nhập lại không khớp!";
            } else {
                try {
                    $stmt = $this->db->prepare("SELECT * FROM nhanvien WHERE Email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        $error = "Email đã tồn tại!";
                    } else {
                        $hashMatKhau = $matKhau; // ❌ Không mã hóa mật khẩu
                        $quyen = 3;
    
                        $stmt = $this->db->prepare("INSERT INTO nhanvien (TenNV, Email, SDT, DiaChi, MatKhau, Quyen) VALUES (?, ?, ?, ?, ?, ?)");
                        
                        if ($stmt->execute([$tenNV, $email, $sdt, $diaChi, $hashMatKhau, $quyen])) {
                            echo "✅ Đăng ký thành công! Chuyển hướng...";
                            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
                            exit;
                        } else {
                            echo "❌ Lỗi khi đăng ký!";
                            print_r($stmt->errorInfo()); 
                        }
                    }
                } catch (PDOException $e) {
                    die("Lỗi SQL: " . $e->getMessage()); 
                }
            }
        }
        include __DIR__ . '/../views/auth/register.php';
    }
    
    public function logout() {
        $this->auth->logout();
        header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
        exit;
    }
}

