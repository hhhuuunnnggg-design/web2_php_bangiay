<?php
require_once __DIR__ . '/../../core/db_connect.php';

class CartModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($maKH, $maSP, $soLuong, $size, $maMau)
    {
        try {
            $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH]);
            $maGH = $stmt->fetchColumn();

            if (!$maGH) {
                $sql = "INSERT INTO giohang (MaKH) VALUES (?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maKH]);
                $maGH = $this->db->lastInsertId();
            }

            $sql = "SELECT SoLuong FROM chitietgiohang WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maGH, $maSP, $size, $maMau]);
            $existingQuantity = $stmt->fetchColumn();

            if ($existingQuantity !== false) {
                $newQuantity = $existingQuantity + $soLuong;
                $sql = "UPDATE chitietgiohang SET SoLuong = ? WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$newQuantity, $maGH, $maSP, $size, $maMau]);
            } else {
                $sql = "INSERT INTO chitietgiohang (MaGH, MaSP, SoLuong, Size, MaMau) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maGH, $maSP, $soLuong, $size, $maMau]);
            }

            $this->updateCartCount($maKH);
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm vào giỏ hàng: " . $e->getMessage());
            return false;
        }
    }

    // Lấy tổng số lượng sản phẩm trong giỏ
    public function getCartCount($maKH)
    {
        $sql = "SELECT TongSoLuong FROM giohang WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchColumn() ?: 0;
    }

    // Cập nhật tổng số lượng trong giỏ
    private function updateCartCount($maKH)
    {
        $sql = "UPDATE giohang SET TongSoLuong = (SELECT SUM(SoLuong) FROM chitietgiohang WHERE MaGH = giohang.MaGH) WHERE MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
    }

    // Lấy chi tiết giỏ hàng
    public function getCartItems($maKH)
    {
        $sql = "SELECT sp.TenSP, ctgh.SoLuong, ctgh.Size, ctgh.MaMau, sp.DonGia, sp.AnhNen
                FROM chitietgiohang ctgh
                JOIN giohang gh ON ctgh.MaGH = gh.MaGH
                JOIN sanpham sp ON ctgh.MaSP = sp.MaSP
                WHERE gh.MaKH = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$maKH]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
