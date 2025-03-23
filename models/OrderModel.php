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

    public function getAllOrders($search = '', $limit = 5, $offset = 0, $maNV = null, $quyen = null)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT h.*, kh.TenKH, nv.TenNV AS TenNVQuanLy, nv_gh.TenNV AS TenShipper 
            FROM hoadon h 
            LEFT JOIN khachhang kh ON h.MaKH = kh.MaKH 
            LEFT JOIN nhanvien nv ON h.MaNV = nv.MaNV 
            LEFT JOIN nhanvien nv_gh ON h.MaNVGH = nv_gh.MaNV 
            WHERE (h.MaHD LIKE '%$search%' OR kh.TenKH LIKE '%$search%')";

        // Nếu là Shipper (Quyen = 2), chỉ hiển thị hóa đơn được gán cho họ
        if ($quyen == 2 && $maNV !== null) {
            $sql .= " AND h.MaNVGH = ?";
        }

        $sql .= " LIMIT ? OFFSET ?";

        $stmt = $this->conn->prepare($sql);

        if ($quyen == 2 && $maNV !== null) {
            $stmt->bind_param("iii", $maNV, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalOrders($search = '', $maNV = null, $quyen = null)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
            FROM hoadon h 
            LEFT JOIN khachhang kh ON h.MaKH = kh.MaKH 
            WHERE (h.MaHD LIKE '%$search%' OR kh.TenKH LIKE '%$search%')";

        if ($quyen == 2 && $maNV !== null) {
            $sql .= " AND h.MaNVGH = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $maNV);
            $stmt->execute();
            $result = $stmt->get_result();
        } else {
            $result = $this->conn->query($sql);
        }

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
        $this->conn->begin_transaction();

        try {
            // Lấy thông tin hóa đơn hiện tại
            $currentOrder = $this->getOrderById($maHD);
            if (!$currentOrder) {
                throw new Exception("Hóa đơn không tồn tại.");
            }

            // Cập nhật tình trạng và ngày giao
            $sql = "UPDATE hoadon SET TinhTrang = ?, NgayGiao = ? WHERE MaHD = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssi", $tinhTrang, $ngayGiao, $maHD);
            $stmt->execute();

            // Nếu chuyển sang "Hủy Bỏ" và trước đó không phải "Hủy Bỏ"
            if ($tinhTrang === 'Hủy Bỏ' && $currentOrder['TinhTrang'] !== 'Hủy Bỏ') {
                $orderDetails = $this->getOrderDetails($maHD);
                foreach ($orderDetails as $detail) {
                    // Cộng lại số lượng vào bảng sanpham
                    $sql = "UPDATE sanpham SET SoLuong = SoLuong + ? WHERE MaSP = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("ii", $detail['SoLuong'], $detail['MaSP']);
                    $stmt->execute();

                    // Cộng lại số lượng vào bảng chitietsanpham
                    $sql = "UPDATE chitietsanpham SET SoLuong = SoLuong + ? 
                        WHERE MaSP = ? AND MaSize = ? AND MaMau = ?";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bind_param("iiss", $detail['SoLuong'], $detail['MaSP'], $detail['Size'], $detail['MaMau']);
                    $stmt->execute();
                }
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollback();
            error_log("Lỗi khi cập nhật hóa đơn: " . $e->getMessage());
            return false;
        }
    }

    public function getShippers()
    {
        $sql = "SELECT MaNV, TenNV FROM nhanvien WHERE Quyen = 2";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Gán Shipper cho hóa đơn
    public function assignShipper($maHD, $maNVGH)
    {
        $sql = "UPDATE hoadon SET MaNVGH = ? WHERE MaHD = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $maNVGH, $maHD);
        return $stmt->execute();
    }


    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
