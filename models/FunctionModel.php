<?php
require_once __DIR__ . '/../core/db_connect.php';

class FunctionModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả chức năng với phân trang
    public function getAllFunctions($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM danhmucchucnang WHERE tenchucnang LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số chức năng để phân trang
    public function getTotalFunctions($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM danhmucchucnang WHERE tenchucnang LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy chức năng theo ID
    public function getFunctionById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM danhmucchucnang WHERE chucnang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm chức năng
    public function addFunction($data) {
        $sql = "INSERT INTO danhmucchucnang (chucnang, tenchucnang) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $data['chucnang'], $data['tenchucnang']);
        return $stmt->execute();
    }

    // Cập nhật chức năng
    public function updateFunction($id, $data) {
        $sql = "UPDATE danhmucchucnang SET chucnang = ?, tenchucnang = ? WHERE chucnang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isi", $data['chucnang'], $data['tenchucnang'], $id);
        return $stmt->execute();
    }

    // Xóa chức năng
    public function deleteFunction($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM danhmucchucnang WHERE chucnang = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}