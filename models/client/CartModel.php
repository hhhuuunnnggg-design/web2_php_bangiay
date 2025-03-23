<?php
require_once __DIR__ . '/../../core/db_connect.php';
require_once __DIR__ . '/ProductModel.php';

class CartModel
{
    private $db;
    private $productModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->productModel = new ProductModel();
    }

    public function addToCart($maKH, $maSP, $soLuong, $size, $maMau)
    {
        try {
            $product = $this->productModel->getProductById($maSP);
            if (!$product) {
                return false;
            }

            $tenSanPham = $product['TenSP'];
            $giaTien = $product['GiaKhuyenMai'];
            $img = $product['AnhNen'];
            $tongTienChiTiet = $giaTien * $soLuong;

            $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH]);
            $maGH = $stmt->fetchColumn();

            if (!$maGH) {
                $sql = "INSERT INTO giohang (MaKH, TongSoLuong, TongTien) VALUES (?, 0, 0)";
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
                $newTongTienChiTiet = $giaTien * $newQuantity;
                $sql = "UPDATE chitietgiohang SET SoLuong = ?, TongTien = ? WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$newQuantity, $newTongTienChiTiet, $maGH, $maSP, $size, $maMau]);
            } else {
                $sql = "INSERT INTO chitietgiohang (MaGH, MaSP, TenSanPham, Img, GiaTien, TongTien, SoLuong, Size, MaMau) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maGH, $maSP, $tenSanPham, $img, $giaTien, $tongTienChiTiet, $soLuong, $size, $maMau]);
            }

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
            SET TongSoLuong = (
                SELECT COUNT(DISTINCT MaSP) 
                FROM chitietgiohang 
                WHERE MaGH = giohang.MaGH
            ), 
            TongTien = (
                SELECT SUM(TongTien) 
                FROM chitietgiohang 
                WHERE MaGH = giohang.MaGH
            ) 
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

    public function clearCart($maKH)
    {
        try {
            $sql = "SELECT MaGH FROM giohang WHERE MaKH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH]);
            $maGH = $stmt->fetchColumn();

            if ($maGH) {
                $sql = "DELETE FROM chitietgiohang WHERE MaGH = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maGH]);
                $sql = "DELETE FROM giohang WHERE MaKH = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maKH]);
            }
            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa giỏ hàng: " . $e->getMessage());
            return false;
        }
    }

    public function removeFromCart($maKH, $maGH, $maSP, $size, $maMau)
    {
        try {
            $sql = "DELETE FROM chitietgiohang WHERE MaGH = ? AND MaSP = ? AND Size = ? AND MaMau = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maGH, $maSP, $size, $maMau]);
            $this->updateCartTotals($maKH);

            $sql = "SELECT COUNT(*) FROM chitietgiohang WHERE MaGH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maGH]);
            if ($stmt->fetchColumn() == 0) {
                $sql = "DELETE FROM giohang WHERE MaGH = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maGH]);
            }

            return true;
        } catch (PDOException $e) {
            error_log("Lỗi khi xóa sản phẩm khỏi giỏ hàng: " . $e->getMessage());
            return false;
        }
    }

    public function processCheckout($maKH, $tenNN, $diaChiNN, $sdtNN)
    {
        try {
            $this->db->beginTransaction();

            // Lấy thông tin giỏ hàng
            $sql = "SELECT MaGH, TongTien FROM giohang WHERE MaKH = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH]);
            $cart = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cart) {
                throw new Exception("Giỏ hàng không tồn tại!");
            }

            $maGH = $cart['MaGH'];
            $tongTien = $cart['TongTien'];

            // Tạo hóa đơn mới
            $sql = "INSERT INTO hoadon (MaKH, TongTien, TinhTrang) VALUES (?, ?, 'Chờ xử lý')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maKH, $tongTien]);
            $maHD = $this->db->lastInsertId();

            // Lấy chi tiết giỏ hàng
            $cartItems = $this->getCartItems($maKH);
            foreach ($cartItems as $item) {
                // Thêm chi tiết hóa đơn
                $sql = "INSERT INTO chitiethoadon (MaHD, MaSP, SoLuong, DonGia, ThanhTien, Size, MaMau, img) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $maHD,
                    $item['MaSP'],
                    $item['SoLuong'],
                    $item['GiaTien'],
                    $item['TongTien'],
                    $item['Size'],
                    $item['MaMau'],
                    $item['Img']
                ]);

                // Cập nhật số lượng trong bảng sanpham
                $sql = "UPDATE sanpham SET SoLuong = SoLuong - ? WHERE MaSP = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$item['SoLuong'], $item['MaSP']]);

                // Cập nhật số lượng trong bảng chitietsanpham
                $sql = "UPDATE chitietsanpham SET SoLuong = SoLuong - ? 
                    WHERE MaSP = ? AND MaSize = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$item['SoLuong'], $item['MaSP'], $item['Size'], $item['MaMau']]);
            }

            // Thêm thông tin người nhận
            $sql = "INSERT INTO nguoinhan (MaHD, TenNN, DiaChiNN, SDTNN) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$maHD, $tenNN, $diaChiNN, $sdtNN]);

            // Xóa giỏ hàng
            $this->clearCart($maKH);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Lỗi khi xử lý thanh toán: " . $e->getMessage());
            return false;
        }
    }
}
