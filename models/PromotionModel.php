<?php
require_once __DIR__ . '/../core/db_connect.php';

class PromotionModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả khuyến mãi với phân trang
    public function getAllPromotions($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM khuyenmai WHERE TenKM LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số khuyến mãi để phân trang
    public function getTotalPromotions($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM khuyenmai WHERE TenKM LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy khuyến mãi theo ID
    public function getPromotionById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM khuyenmai WHERE MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm khuyến mãi
    public function addPromotion($data) {
        $sql = "INSERT INTO khuyenmai (TenKM, MoTa, KM_PT, TienKM, NgayBD, NgayKT) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisss", $data['TenKM'], $data['MoTa'], $data['KM_PT'], $data['TienKM'], $data['NgayBD'], $data['NgayKT']);
        return $stmt->execute();
    }

    // Cập nhật khuyến mãi
    public function updatePromotion($id, $data) {
        $sql = "UPDATE khuyenmai SET TenKM = ?, MoTa = ?, KM_PT = ?, TienKM = ?, NgayBD = ?, NgayKT = ? WHERE MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssisssi", $data['TenKM'], $data['MoTa'], $data['KM_PT'], $data['TienKM'], $data['NgayBD'], $data['NgayKT'], $id);
        return $stmt->execute();
    }

    // Xóa khuyến mãi
    public function deletePromotion($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM khuyenmai WHERE MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}