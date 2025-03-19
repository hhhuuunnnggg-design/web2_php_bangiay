<?php
require_once __DIR__ . '/../core/db_connect.php';

class StatsModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getRevenueStats()
    {
        $sql = "SELECT DATE_FORMAT(NgayDat, '%Y-%m') AS Thang, SUM(TongTien) AS DoanhThu 
                FROM hoadon 
                WHERE TinhTrang = 'Đã giao' 
                GROUP BY DATE_FORMAT(NgayDat, '%Y-%m') 
                ORDER BY Thang DESC 
                LIMIT 12";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTopProducts()
    {
        $sql = "SELECT sp.MaSP, sp.TenSP, SUM(ct.SoLuong) AS SoLuongBan 
                FROM chitiethoadon ct 
                JOIN sanpham sp ON ct.MaSP = sp.MaSP 
                JOIN hoadon hd ON ct.MaHD = hd.MaHD 
                WHERE hd.TinhTrang = 'Đã giao' 
                GROUP BY sp.MaSP, sp.TenSP 
                ORDER BY SoLuongBan DESC 
                LIMIT 10";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getEmployeeStats()
    {
        $sql = "SELECT nv.MaNV, nv.TenNV, COUNT(hd.MaHD) AS SoHoaDon 
                FROM nhanvien nv 
                LEFT JOIN hoadon hd ON nv.MaNV = hd.MaNV 
                WHERE hd.TinhTrang = 'Đã giao' 
                GROUP BY nv.MaNV, nv.TenNV 
                ORDER BY SoHoaDon DESC 
                LIMIT 10";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
