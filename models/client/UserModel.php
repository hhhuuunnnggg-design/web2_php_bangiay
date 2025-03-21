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

    // Lấy thông tin người dùng theo MaKH
    public function getUserInfo($maKH)
    {
        $sql = "SELECT TenKH, Email, SDT, DiaChi, MatKhau FROM khachhang WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Cập nhật thông tin người dùng
    public function updateUser($maKH, $tenKH, $email, $sdt, $diaChi, $matKhau)
    {
        $tenKH = $this->conn->real_escape_string($tenKH);
        $email = $this->conn->real_escape_string($email);
        $sdt = $this->conn->real_escape_string($sdt);
        $diaChi = $this->conn->real_escape_string($diaChi);
        $matKhau = $this->conn->real_escape_string($matKhau);

        $sql = "UPDATE khachhang SET TenKH = ?, Email = ?, SDT = ?, DiaChi = ?, MatKhau = ? WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissi", $tenKH, $email, $sdt, $diaChi, $matKhau, $maKH);
        return $stmt->execute();
    }

    // Các hàm cũ giữ nguyên
    public function register($tenKH, $email, $sdt, $diaChi, $matKhau)
    {
        $email = $this->conn->real_escape_string($email);
        $tenKH = $this->conn->real_escape_string($tenKH);
        $sdt = $this->conn->real_escape_string($sdt);
        $diaChi = $this->conn->real_escape_string($diaChi);
        $matKhau = $this->conn->real_escape_string($matKhau);

        $sql = "INSERT INTO khachhang (TenKH, Email, SDT, DiaChi, MatKhau) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssiss", $tenKH, $email, $sdt, $diaChi, $matKhau);
        return $stmt->execute();
    }

    public function emailExists($email)
    {
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT MaKH FROM khachhang WHERE Email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function login($email, $matKhau)
    {
        $email = $this->conn->real_escape_string($email);
        $matKhau = $this->conn->real_escape_string($matKhau);
        $sql = "SELECT MaKH, TenKH, MatKhau FROM khachhang WHERE Email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result && $matKhau === $result['MatKhau']) {
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
