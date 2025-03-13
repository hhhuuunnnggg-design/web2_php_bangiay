<?php
require_once __DIR__ . '/../core/db_connect.php';

class ColorModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả màu với phân trang
    public function getAllColors($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM mau WHERE MaMau LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số màu để tính phân trang
    public function getTotalColors($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM mau WHERE MaMau LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy màu theo MaMau
    public function getColorById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM mau WHERE MaMau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm màu
    public function addColor($data) {
        $sql = "INSERT INTO mau (MaMau) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $data['MaMau']);
        return $stmt->execute();
    }

    // Cập nhật màu
    public function updateColor($id, $data) {
        $sql = "UPDATE mau SET MaMau = ? WHERE MaMau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $data['MaMau'], $id);
        return $stmt->execute();
    }

    // Xóa màu
    public function deleteColor($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM mau WHERE MaMau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}