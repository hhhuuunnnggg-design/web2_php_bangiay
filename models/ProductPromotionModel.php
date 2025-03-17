<?php
require_once __DIR__ . '/../core/db_connect.php';

class ProductPromotionModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
        $this->cleanupExpiredPromotions(); // Gọi hàm xóa tự động khi khởi tạo
    }

    // Xóa tự động các sản phẩm khuyến mãi có khuyến mãi đã hết hạn
    private function cleanupExpiredPromotions()
    {
        $currentDate = date('Y-m-d'); // Thời gian hiện tại chỉ lấy ngày
        $sql = "DELETE spkm FROM sanphamkhuyenmai spkm
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM
                WHERE km.NgayKT < ?"; // Dùng NgayKT thay vì NgayKetThuc
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            error_log("Đã xóa {$stmt->affected_rows} sản phẩm khuyến mãi hết hạn vào " . $currentDate);
        }
    }

    // Lấy tất cả sản phẩm khuyến mãi với phân trang và tìm kiếm
    public function getAllProductPromotions($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT spkm.*, sp.TenSP, km.TenKM 
                FROM sanphamkhuyenmai spkm 
                JOIN sanpham sp ON spkm.MaSP = sp.MaSP 
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM 
                WHERE (sp.TenSP LIKE '%$search%' OR km.TenKM LIKE '%$search%')
                AND km.NgayKT >= CURDATE() -- Chỉ lấy khuyến mãi còn hiệu lực (so với ngày hiện tại)
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function getTotalProductPromotions($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM sanphamkhuyenmai spkm 
                JOIN sanpham sp ON spkm.MaSP = sp.MaSP 
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM 
                WHERE (sp.TenSP LIKE '%$search%' OR km.TenKM LIKE '%$search%')
                AND km.NgayKT >= CURDATE()"; // Chỉ đếm khuyến mãi còn hiệu lực
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy sản phẩm khuyến mãi theo MaSP và MaKM
    public function getProductPromotion($maSP, $maKM)
    {
        $sql = "SELECT spkm.*, sp.TenSP, km.TenKM 
                FROM sanphamkhuyenmai spkm 
                JOIN sanpham sp ON spkm.MaSP = sp.MaSP 
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM 
                WHERE spkm.MaSP = ? AND spkm.MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $maSP, $maKM);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }


    public function addProductPromotion($data)
    {
        // Kiểm tra khuyến mãi còn hiệu lực không
        $sqlCheck = "SELECT NgayKT FROM khuyenmai WHERE MaKM = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $data['MaKM']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result()->fetch_assoc();

        if ($result && $result['NgayKT'] < date('Y-m-d')) { // So sánh với ngày hiện tại
            return false; // Không thêm nếu khuyến mãi đã hết hạn
        }

        $sql = "INSERT INTO sanphamkhuyenmai (MaSP, MaKM) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $data['MaSP'], $data['MaKM']);
        return $stmt->execute();
    }


    public function updateProductPromotion($oldMaSP, $oldMaKM, $data)
    {
        // Kiểm tra khuyến mãi mới còn hiệu lực không
        $sqlCheck = "SELECT NgayKT FROM khuyenmai WHERE MaKM = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $data['MaKM']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result()->fetch_assoc();

        if ($result && $result['NgayKT'] < date('Y-m-d')) { // So sánh với ngày hiện tại
            return false; // Không cập nhật nếu khuyến mãi mới đã hết hạn
        }

        $sql = "UPDATE sanphamkhuyenmai SET MaSP = ?, MaKM = ? WHERE MaSP = ? AND MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $data['MaSP'], $data['MaKM'], $oldMaSP, $oldMaKM);
        return $stmt->execute();
    }


    public function deleteProductPromotion($maSP, $maKM)
    {
        $sql = "DELETE FROM sanphamkhuyenmai WHERE MaSP = ? AND MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $maSP, $maKM);
        return $stmt->execute();
    }


    public function getProducts()
    {
        $sql = "SELECT MaSP, TenSP FROM sanpham";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách khuyến mãi còn hiệu lực
    public function getPromotions()
    {
        $sql = "SELECT MaKM, TenKM FROM khuyenmai WHERE NgayKT >= CURDATE()"; // Chỉ lấy khuyến mãi còn hiệu lực
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
