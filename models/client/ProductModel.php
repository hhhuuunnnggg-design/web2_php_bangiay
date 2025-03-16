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

        // Lấy thông tin sản phẩm theo ID
    public function getProductById($productId) {
        $productId = $this->conn->real_escape_string($productId);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC 
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
                WHERE sp.MaSP = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Lấy chi tiết kích thước và màu sắc của sản phẩm
    public function getProductDetails($productId) {
        // Tránh lỗi SQL Injection bằng cách làm sạch đầu vào từ người dùng
        $productId = $this->conn->real_escape_string($productId);
        
        // Khai báo câu lệnh SQL để lấy thông tin chi tiết sản phẩm từ bảng 'chitietsanpham'
        $sql = "SELECT MaSize, MaMau, SoLuong 
                FROM chitietsanpham 
                WHERE MaSP = ?"; // Dấu '?' là một placeholder cho giá trị sẽ được bind vào sau
        
        // Chuẩn bị câu lệnh SQL bằng prepared statement để tránh lỗi SQL Injection
        $stmt = $this->conn->prepare($sql);
        
        // Gán giá trị cho placeholder '?' trong câu lệnh SQL
        // "i" là kiểu dữ liệu của giá trị được bind vào:
        //   - "i" = integer (số nguyên)
        //   - Nếu là chuỗi thì dùng "s", nếu là số thực thì dùng "d", nếu là blob thì dùng "b"
        $stmt->bind_param("i", $productId);
        
        // Thực thi câu lệnh SQL
        $stmt->execute();
        
        // Lấy kết quả trả về từ câu lệnh SQL và chuyển thành mảng kết hợp (associative array)
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function __destruct() {
        // Hàm hủy (destructor) sẽ tự động được gọi khi đối tượng bị hủy
        // Đóng kết nối với cơ sở dữ liệu để tránh rò rỉ bộ nhớ
        $this->db->closeConnection();
    }
    
}