<?php
require_once __DIR__ . '/../core/db_connect.php';

class CategoryModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả danh mục
    public function getAllCategories($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM danhmuc WHERE TenDM LIKE '%$search%'";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Lỗi SQL: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh mục theo ID
    public function getCategoryById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM danhmuc WHERE MaDM = '$id'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    // Thêm danh mục
    public function addCategory($data) {
        $sql = "INSERT INTO danhmuc (TenDM) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $data['TenDM']);
        return $stmt->execute();
    }

    // Cập nhật danh mục
    public function updateCategory($id, $data) {
        $sql = "UPDATE danhmuc SET TenDM = ? WHERE MaDM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data['TenDM'], $id);
        return $stmt->execute();
    }

    // Xóa danh mục
    public function deleteCategory($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM danhmuc WHERE MaDM = '$id'";
        return $this->conn->query($sql);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}