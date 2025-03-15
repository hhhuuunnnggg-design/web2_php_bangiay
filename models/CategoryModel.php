<?php
require_once __DIR__ . '/../core/db_connect.php';

class CategoryModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllCategories($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM danhmuc WHERE TenDM LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalCategories($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM danhmuc WHERE TenDM LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getCategoryById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM danhmuc WHERE MaDM = '$id'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function addCategory($data) {
        $sql = "INSERT INTO danhmuc (TenDM) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $data['TenDM']);
        return $stmt->execute();
    }

    public function updateCategory($id, $data) {
        $sql = "UPDATE danhmuc SET TenDM = ? WHERE MaDM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $data['TenDM'], $id);
        return $stmt->execute();
    }

    public function deleteCategory($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM danhmuc WHERE MaDM = '$id'";
        return $this->conn->query($sql);
    }

    public function importCategory($data) {
        // Kiểm tra xem MaDM đã tồn tại chưa, nếu có thì update, nếu không thì insert
        $sqlCheck = "SELECT MaDM FROM danhmuc WHERE MaDM = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $data['MaDM']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Update nếu MaDM đã tồn tại
            $sql = "UPDATE danhmuc SET TenDM = ? WHERE MaDM = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("si", $data['TenDM'], $data['MaDM']);
            $stmt->execute();
        } else {
            // Insert nếu MaDM chưa tồn tại
            $sql = "INSERT INTO danhmuc (MaDM, TenDM) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("is", $data['MaDM'], $data['TenDM']);
            $stmt->execute();
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}