<?php
require_once __DIR__ . '/../../core/db_connect.php';

class CartModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addToCart($maKH, $maSP, $soLuong, $size, $maMau)
    {
        try {
            // Lấy thông tin sản phẩm từ bảng sanpham
            $sql = "SELECT TenSP, DonGia, AnhNen FROM sanpham WHERE MaSP = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maSP]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                return false; // Sản phẩm không tồn tại
            }

            $tenSanPham = $product['TenSP'];
            $giaTien = $product['DonGia'];
            $img = $product['AnhNen'];
            $tongTienChiTiet = $giaTien * $soLuong; // Tổng tiền cho sản phẩm này

            // Kiểm tra giỏ hàng của khách hàng
            $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH]);
            $maGH = $stmt->fetchColumn();

            if (!$maGH) {
                // Nếu chưa có giỏ hàng, tạo mới
                $sql = "INSERT INTO giohang (MaKH, TongSoLuong, TongTien) VALUES (?, 0, 0)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maKH]);
                $maGH = $this->db->lastInsertId();
            }

            // Kiểm tra sản phẩm đã có trong giỏ chưa
            $sql = "SELECT SoLuong FROM chitietgiohang WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maGH, $maSP, $size, $maMau]);
            $existingQuantity = $stmt->fetchColumn();

            if ($existingQuantity !== false) {
                // Nếu đã có, cập nhật số lượng và tổng tiền
                $newQuantity = $existingQuantity + $soLuong;
                $newTongTienChiTiet = $giaTien * $newQuantity;
                $sql = "UPDATE chitietgiohang SET SoLuong = ?, TongTien = ? WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$newQuantity, $newTongTienChiTiet, $maGH, $maSP, $size, $maMau]);
            } else {
                // Nếu chưa có, thêm mới
                $sql = "INSERT INTO chitietgiohang (MaGH, MaSP, TenSanPham, Img, GiaTien, TongTien, SoLuong, Size, MaMau) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maGH, $maSP, $tenSanPham, $img, $giaTien, $tongTienChiTiet, $soLuong, $size, $maMau]);
            }

            // Cập nhật tổng số lượng và tổng tiền trong giỏ hàng
            $this->updateCartTotals($maKH);
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm vào giỏ hàng: " . $e->getMessage());
            return false;
        }
    }

    public function getCartCount($maKH)
    {
        $sql = "SELECT TongSoLuong FROM giohang WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchColumn() ?: 0;
    }

    public function getCartTotal($maKH)
    {
        $sql = "SELECT TongTien FROM giohang WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchColumn() ?: 0;
    }

    private function updateCartTotals($maKH)
    {
        $sql = "UPDATE giohang 
                SET TongSoLuong = (SELECT SUM(SoLuong) FROM chitietgiohang WHERE MaGH = giohang.MaGH), 
                    TongTien = (SELECT SUM(TongTien) FROM chitietgiohang WHERE MaGH = giohang.MaGH) 
                WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
    }

    public function getCartItems($maKH)
    {
        $sql = "SELECT ctgh.*, sp.TenSP, sp.DonGia, sp.AnhNen
                FROM chitietgiohang ctgh
                JOIN giohang gh ON ctgh.MaGH = gh.MaGH
                JOIN sanpham sp ON ctgh.MaSP = sp.MaSP
                WHERE gh.MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
