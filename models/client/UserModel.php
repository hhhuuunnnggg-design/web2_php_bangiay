<?php
require_once __DIR__ . '/../../core/db_connect.php';

class UserModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Đăng ký khách hàng mới (không mã hóa mật khẩu)
    public function register($tenKH, $email, $sdt, $diaChi, $matKhau)
    {
        $email = $this->conn->real_escape_string($email);
        $tenKH = $this->conn->real_escape_string($tenKH);
        $sdt = $this->conn->real_escape_string($sdt);
        $diaChi = $this->conn->real_escape_string($diaChi);
        $matKhau = $this->conn->real_escape_string($matKhau); // Lưu dạng văn bản thô

        $sql = "INSERT INTO khachhang (TenKH, Email, SDT, DiaChi, MatKhau) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiss", $tenKH, $email, $sdt, $diaChi, $matKhau);
        return $stmt->execute();
    }

    // Kiểm tra email đã tồn tại chưa
    public function emailExists($email)
    {
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT MaKH FROM khachhang WHERE Email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    // Đăng nhập (so sánh mật khẩu thô)
    public function login($email, $matKhau)
    {
        $email = $this->conn->real_escape_string($email);
        $matKhau = $this->conn->real_escape_string($matKhau);
        $sql = "SELECT MaKH, TenKH, MatKhau FROM khachhang WHERE Email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && $matKhau === $result['MatKhau']) { // So sánh trực tiếp
            return [
                'MaKH' => $result['MaKH'],
                'TenKH' => $result['TenKH']
            ];
        }
        return false;
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
