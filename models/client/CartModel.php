<?php
require_once __DIR__ . '/../../core/db_connect.php';

class CartModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy hoặc tạo MaGH cho khách hàng
    private function getCartId($maKH)
    {
        $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            return $result['MaGH'];
        } else {
            $sql = "INSERT INTO giohang (MaKH, NgayTao) VALUES (?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $maKH);
            $stmt->execute();
            return $this->conn->insert_id;
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($maKH, $maSP, $size, $maMau, $soLuong)
    {
        $maGH = $this->getCartId($maKH);

        // Kiểm tra sản phẩm đã tồn tại trong giỏ chưa
        $sql = "SELECT SoLuong FROM chitietgiohang WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiis", $maGH, $maSP, $size, $maMau);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            // Cập nhật số lượng nếu đã tồn tại
            $newQuantity = $result['SoLuong'] + $soLuong;
            $sql = "UPDATE chitietgiohang SET SoLuong = ? WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiis", $newQuantity, $maGH, $maSP, $size, $maMau);
        } else {
            // Thêm mới nếu chưa tồn tại
            $sql = "INSERT INTO chitietgiohang (MaGH, MaSP, SoLuong, Size, MaMau) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("iiiss", $maGH, $maSP, $soLuong, $size, $maMau);
        }
        return $stmt->execute();
    }

    // Đếm số lượng sản phẩm trong giỏ
    public function getCartItemCount($maKH)
    {
        $maGH = $this->getCartId($maKH);
        $sql = "SELECT SUM(SoLuong) as total FROM chitietgiohang WHERE MaGH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maGH);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    // Lấy chi tiết giỏ hàng
    public function getCartDetails($maKH)
    {
        $maGH = $this->getCartId($maKH);
        $sql = "SELECT ct.MaSP, ct.SoLuong, ct.Size, ct.MaMau, sp.TenSP, sp.AnhNen, sp.GiaKhuyenMai
                FROM chitietgiohang ct
                JOIN sanpham sp ON ct.MaSP = sp.MaSP
                WHERE ct.MaGH = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maGH);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
