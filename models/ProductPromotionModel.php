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
    }

    // Lấy tất cả sản phẩm khuyến mãi với phân trang và tìm kiếm
    public function getAllProductPromotions($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT spkm.*, sp.TenSP, km.TenKM 
                FROM sanphamkhuyenmai spkm 
                JOIN sanpham sp ON spkm.MaSP = sp.MaSP 
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM 
                WHERE sp.TenSP LIKE '%$search%' OR km.TenKM LIKE '%$search%' 
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số sản phẩm khuyến mãi để phân trang
    public function getTotalProductPromotions($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM sanphamkhuyenmai spkm 
                JOIN sanpham sp ON spkm.MaSP = sp.MaSP 
                JOIN khuyenmai km ON spkm.MaKM = km.MaKM 
                WHERE sp.TenSP LIKE '%$search%' OR km.TenKM LIKE '%$search%'";
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

    // Thêm sản phẩm khuyến mãi
    public function addProductPromotion($data)
    {
        $sql = "INSERT INTO sanphamkhuyenmai (MaSP, MaKM) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $data['MaSP'], $data['MaKM']);
        return $stmt->execute();
    }

    // Cập nhật sản phẩm khuyến mãi
    public function updateProductPromotion($oldMaSP, $oldMaKM, $data)
    {
        $sql = "UPDATE sanphamkhuyenmai SET MaSP = ?, MaKM = ? WHERE MaSP = ? AND MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiii", $data['MaSP'], $data['MaKM'], $oldMaSP, $oldMaKM);
        return $stmt->execute();
    }

    // Xóa sản phẩm khuyến mãi
    public function deleteProductPromotion($maSP, $maKM)
    {
        $sql = "DELETE FROM sanphamkhuyenmai WHERE MaSP = ? AND MaKM = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $maSP, $maKM);
        return $stmt->execute();
    }

    // Lấy danh sách sản phẩm
    public function getProducts()
    {
        $sql = "SELECT MaSP, TenSP FROM sanpham";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách khuyến mãi
    public function getPromotions()
    {
        $sql = "SELECT MaKM, TenKM FROM khuyenmai";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
