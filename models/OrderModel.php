<?php
require_once __DIR__ . '/../core/db_connect.php';

class OrderModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllOrders($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT h.*, kh.TenKH, nv.TenNV 
                FROM hoadon h 
                LEFT JOIN khachhang kh ON h.MaKH = kh.MaKH 
                LEFT JOIN nhanvien nv ON h.MaNV = nv.MaNV 
                WHERE h.MaHD LIKE '%$search%' OR kh.TenKH LIKE '%$search%'
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalOrders($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM hoadon h 
                LEFT JOIN khachhang kh ON h.MaKH = kh.MaKH 
                WHERE h.MaHD LIKE '%$search%' OR kh.TenKH LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getOrderById($maHD)
    {
        $maHD = $this->conn->real_escape_string($maHD);
        $sql = "SELECT h.*, kh.TenKH, nv.TenNV 
                FROM hoadon h 
                LEFT JOIN khachhang kh ON h.MaKH = kh.MaKH 
                LEFT JOIN nhanvien nv ON h.MaNV = nv.MaNV 
                WHERE h.MaHD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maHD);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getOrderDetails($maHD)
    {
        $maHD = $this->conn->real_escape_string($maHD);
        $sql = "SELECT c.*, sp.TenSP 
                FROM chitiethoadon c 
                JOIN sanpham sp ON c.MaSP = sp.MaSP 
                WHERE c.MaHD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maHD);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Cập nhật hàm để xử lý cả TinhTrang và NgayGiao
    public function updateOrderStatus($maHD, $tinhTrang, $ngayGiao)
    {
        $sql = "UPDATE hoadon SET TinhTrang = ?, NgayGiao = ? WHERE MaHD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $tinhTrang, $ngayGiao, $maHD);
        return $stmt->execute();
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
