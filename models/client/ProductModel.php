<?php
require_once __DIR__ . '/../../core/db_connect.php';

class ProductModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy sản phẩm theo danh mục với giới hạn và offset
    public function getProductsByCategory($categoryId, $limit = 5, $offset = 0) {
        $categoryId = $this->conn->real_escape_string($categoryId);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC 
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
                WHERE sp.MaDM = ? 
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $categoryId, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}