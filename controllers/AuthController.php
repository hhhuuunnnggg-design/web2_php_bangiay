<?php
require_once __DIR__ . '/../core/Auth.php';

class AuthController {
    private $auth;
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
