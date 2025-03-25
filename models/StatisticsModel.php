<?php
require_once __DIR__ . '/../core/db_connect.php';

class StatisticsModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getTopCustomers($startDate, $endDate)
    {
        $startDate = $this->conn->real_escape_string($startDate);
        $endDate = $this->conn->real_escape_string($endDate);

        // Lấy 5 khách hàng có tổng tiền cao nhất và danh sách hóa đơn
        $sql = "
            SELECT 
                kh.MaKH,
                kh.TenKH,
                kh.Email,
                SUM(hd.TongTien) AS TongMua,
                hd.MaHD,
                hd.NgayDat,
                hd.TongTien AS ThanhTienDonHang
            FROM 
                khachhang kh
            JOIN 
                hoadon hd ON kh.MaKH = hd.MaKH
            WHERE 
                hd.NgayDat BETWEEN ? AND ?
            GROUP BY 
                kh.MaKH, kh.TenKH, kh.Email, hd.MaHD, hd.NgayDat, hd.TongTien
            ORDER BY 
                TongMua DESC, kh.MaKH, hd.MaHD
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $allData = $result->fetch_all(MYSQLI_ASSOC);

        // Gom dữ liệu theo khách hàng và giới hạn 5 khách hàng
        $topCustomers = [];
        $customerCount = 0;
        $currentMaKH = null;

        foreach ($allData as $row) {
            if ($currentMaKH !== $row['MaKH']) {
                $customerCount++;
                if ($customerCount > 5) break;
                $currentMaKH = $row['MaKH'];
                $topCustomers[$row['MaKH']] = [
                    'MaKH' => $row['MaKH'],
                    'TenKH' => $row['TenKH'],
                    'Email' => $row['Email'],
                    'TongMua' => $row['TongMua'],
                    'Orders' => []
                ];
            }
            $topCustomers[$row['MaKH']]['Orders'][] = [
                'MaHD' => $row['MaHD'],
                'NgayDat' => $row['NgayDat'],
                'ThanhTienDonHang' => $row['ThanhTienDonHang']
            ];
        }

        return array_values($topCustomers); // Chuyển thành mảng không key
    }

    public function getOrderDetails($maHD)
    {
        $maHD = $this->conn->real_escape_string($maHD);
        $sql = "
            SELECT 
                cthd.MaSP,
                cthd.SoLuong,
                cthd.DonGia,
                cthd.ThanhTien AS ThanhTienSanPham,
                cthd.Size,
                cthd.MaMau,
                cthd.img
            FROM 
                chitiethoadon cthd
            WHERE 
                cthd.MaHD = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maHD);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
