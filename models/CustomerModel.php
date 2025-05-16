<?php
require_once __DIR__ . '/../core/db_connect.php';

class CustomerModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllCustomers($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM khachhang WHERE TenKH LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCustomers($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM khachhang WHERE TenKH LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getCustomerById($id)
    {
        $sql = "SELECT * FROM khachhang WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addCustomer($data)
    {
        $hashedPassword = password_hash($data['MatKhau'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO khachhang (MaKH, TenKH, Email, SDT, DiaChi, MatKhau, TrangThai) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $trangThai = 0; // Default status: active
        $stmt->bind_param("isssssi", $data['MaKH'], $data['TenKH'], $data['Email'], $data['SDT'], $data['DiaChi'], $hashedPassword, $trangThai);
        return $stmt->execute();
    }

    public function updateCustomer($id, $data)
    {
        $sql = "UPDATE khachhang SET TenKH = ?, Email = ?, SDT = ?, DiaChi = ?, MatKhau = ? WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $hashedPassword = !empty($data['MatKhau']) ? password_hash($data['MatKhau'], PASSWORD_DEFAULT) : $this->getCustomerById($id)['MatKhau'];
        $stmt->bind_param("sssssi", $data['TenKH'], $data['Email'], $data['SDT'], $data['DiaChi'], $hashedPassword, $id);
        return $stmt->execute();
    }

    public function lockCustomer($id)
    {
        $sql = "UPDATE khachhang SET TrangThai = 1 WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
