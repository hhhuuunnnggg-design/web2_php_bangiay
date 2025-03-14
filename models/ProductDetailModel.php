<?php
require_once __DIR__ . '/../core/db_connect.php';

class ProductDetailModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả chi tiết sản phẩm với phân trang và tìm kiếm nâng cao
    public function getAllProductDetails($search_name = '', $search_color = '', $search_size = '', $limit = 5, $offset = 0) {
        $search_name = $this->conn->real_escape_string($search_name);
        $search_color = $this->conn->real_escape_string($search_color);
        $search_size = $this->conn->real_escape_string($search_size);
        
        $sql = "SELECT ct.*, sp.TenSP, m.MaMau, s.MaSize 
                FROM chitietsanpham ct 
                JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                JOIN mau m ON ct.MaMau = m.MaMau 
                JOIN size s ON ct.MaSize = s.MaSize 
                WHERE sp.TenSP LIKE '%$search_name%'";
        
        if (!empty($search_color)) {
            $sql .= " AND ct.MaMau LIKE '%$search_color%'";
        }
        if (!empty($search_size)) {
            $sql .= " AND ct.MaSize LIKE '%$search_size%'";
        }
        
        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số chi tiết sản phẩm để phân trang
    public function getTotalProductDetails($search_name = '', $search_color = '', $search_size = '') {
        $search_name = $this->conn->real_escape_string($search_name);
        $search_color = $this->conn->real_escape_string($search_color);
        $search_size = $this->conn->real_escape_string($search_size);
        
        $sql = "SELECT COUNT(*) as total 
                FROM chitietsanpham ct 
                JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                WHERE sp.TenSP LIKE '%$search_name%'";
        
        if (!empty($search_color)) {
            $sql .= " AND ct.MaMau LIKE '%$search_color%'";
        }
        if (!empty($search_size)) {
            $sql .= " AND ct.MaSize LIKE '%$search_size%'";
        }
        
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}