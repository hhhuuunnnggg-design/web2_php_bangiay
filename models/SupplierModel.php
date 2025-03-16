<?php
require_once __DIR__ . '/../core/db_connect.php';

class SupplierModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả nhà cung cấp với phân trang
    public function getAllSuppliers($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM nhacc WHERE TenNCC LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số nhà cung cấp để tính phân trang
    public function getTotalSuppliers($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM nhacc WHERE TenNCC LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy nhà cung cấp theo MaNCC
    public function getSupplierById($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM nhacc WHERE MaNCC = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm nhà cung cấp
    public function addSupplier($data)
    {
        $sql = "INSERT INTO nhacc (TenNCC) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $data['TenNCC']);
        return $stmt->execute();
    }

    // Cập nhật nhà cung cấp
    public function updateSupplier($id, $data)
    {
        $sql = "UPDATE nhacc SET TenNCC = ? WHERE MaNCC = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data['TenNCC'], $id);
        return $stmt->execute();
    }

    // Xóa nhà cung cấp
    public function deleteSupplier($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM nhacc WHERE MaNCC = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
