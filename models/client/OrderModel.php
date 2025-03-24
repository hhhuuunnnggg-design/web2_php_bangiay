<?php
class OrderModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOrdersByCustomer($maKH, $tinhTrang = null)
    {
        $sql = "SELECT h.*, nn.TenNN, nn.DiaChiNN, nn.SDTNN
                FROM hoadon h 
                LEFT JOIN nguoinhan nn ON h.MaHD = nn.MaHD
                WHERE h.MaKH = ?";
        if ($tinhTrang !== null) {
            $sql .= " AND h.TinhTrang = ?";
        }
        $sql .= " ORDER BY h.NgayDat DESC";

        $stmt = $this->db->prepare($sql);
        if ($tinhTrang !== null) {
            $stmt->bindParam(1, $maKH, PDO::PARAM_INT);
            $stmt->bindParam(2, $tinhTrang, PDO::PARAM_STR);
        } else {
            $stmt->bindParam(1, $maKH, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($maHD)
    {
        $sql = "SELECT h.*, nn.TenNN, nn.DiaChiNN, nn.SDTNN
                FROM hoadon h
                LEFT JOIN nguoinhan nn ON h.MaHD = nn.MaHD
                WHERE h.MaHD = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $maHD, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($maHD)
    {
        $sql = "SELECT c.*, sp.TenSP
                FROM chitiethoadon c
                JOIN sanpham sp ON c.MaSP = sp.MaSP
                WHERE c.MaHD = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(1, $maHD, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
