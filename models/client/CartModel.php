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

    private function getCartId($maKH)
    {
        $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $maKH);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            return $result['MaGH'];
        } else {
            $sql = "INSERT INTO giohang (MaKH, NgayTao) VALUES (?, NOW())";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("i", $maKH);
            if (!$stmt->execute()) {
                throw new Exception("Lỗi insert: " . $stmt->error);
            }
            return $this->conn->insert_id;
        }
    }

    public function addToCart($maKH, $maSP, $size, $maMau, $soLuong)
    {
        $maGH = $this->getCartId($maKH);

        $sql = "SELECT SoLuong FROM chitietgiohang WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("iiis", $maGH, $maSP, $size, $maMau);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if ($result) {
            $newQuantity = $result['SoLuong'] + $soLuong;
            $sql = "UPDATE chitietgiohang SET SoLuong = ? WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("iiis", $newQuantity, $maGH, $maSP, $size, $maMau);
        } else {
            $sql = "INSERT INTO chitietgiohang (MaGH, MaSP, SoLuong, Size, MaMau) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Lỗi prepare: " . $this->conn->error);
            }
            $stmt->bind_param("iiiss", $maGH, $maSP, $soLuong, $size, $maMau);
        }
        if (!$stmt->execute()) {
            throw new Exception("Lỗi execute: " . $stmt->error);
        }
        return true;
    }

    public function getCartItemCount($maKH)
    {
        $maGH = $this->getCartId($maKH);
        $sql = "SELECT SUM(SoLuong) as total FROM chitietgiohang WHERE MaGH = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $maGH);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }

    public function getCartDetails($maKH)
    {
        $maGH = $this->getCartId($maKH);
        $sql = "SELECT ct.MaSP, ct.SoLuong, ct.Size, ct.MaMau, sp.TenSP, sp.AnhNen, sp.GiaKhuyenMai
                FROM chitietgiohang ct
                JOIN sanpham sp ON ct.MaSP = sp.MaSP
                WHERE ct.MaGH = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Lỗi prepare: " . $this->conn->error);
        }
        $stmt->bind_param("i", $maGH);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
