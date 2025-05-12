<?php
require_once __DIR__ . '/../../models/client/ProductModel.php';
require_once __DIR__ . '/../../models/client/UserModel.php';

class CheckoutController
{
    private $db;
    private $productModel;
    private $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->productModel = new ProductModel($db);
        $this->userModel = new UserModel($db);
    }

    public function direct()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }

        $maKH = $_SESSION['user']['MaKH'];
        $maSP = $_GET['product'] ?? null;
        $size = $_GET['size'] ?? null;
        $color = $_GET['color'] ?? null;
        $quantity = $_GET['quantity'] ?? 1;

        if (!$maSP || !$size || !$color) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }

        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($maSP);
        if (!$product) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }

        // Lấy thông tin khách hàng
        $userInfo = $this->userModel->getUserInfo($maKH);

        // Tính tổng tiền
        $totalPrice = $product['GiaKhuyenMai'] < $product['DonGia'] ?
            $product['GiaKhuyenMai'] * $quantity :
            $product['DonGia'] * $quantity;

        // Tạo mảng chứa thông tin sản phẩm để hiển thị
        $directItem = [
            'MaSP' => $maSP,
            'TenSanPham' => $product['TenSP'],
            'Img' => $product['AnhNen'],
            'Size' => $size,
            'MaMau' => $color,
            'SoLuong' => $quantity,
            'GiaTien' => $product['GiaKhuyenMai'] < $product['DonGia'] ?
                $product['GiaKhuyenMai'] :
                $product['DonGia'],
            'TongTien' => $totalPrice
        ];

        $title = "Thanh toán";
        include __DIR__ . '/../../views/client/page/direct_checkout.php';
    }

    public function processDirectCheckout()
    {
        session_start();
        header('Content-Type: application/json');
        ob_end_clean();

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKH = $_SESSION['user']['MaKH'];
            $maSP = $_POST['maSP'] ?? null;
            $size = $_POST['size'] ?? null;
            $color = $_POST['color'] ?? null;
            $quantity = $_POST['quantity'] ?? null;
            $tenNN = $_POST['tenNN'] ?? null;
            $diaChiNN = $_POST['diaChiNN'] ?? null;
            $sdtNN = $_POST['sdtNN'] ?? null;

            if (!$maSP || !$size || !$color || !$quantity || !$tenNN || !$diaChiNN || !$sdtNN) {
                echo json_encode(['success' => false, 'message' => 'Thông tin không hợp lệ!']);
                exit;
            }

            try {
                $this->db->beginTransaction();

                // Lấy thông tin sản phẩm
                $product = $this->productModel->getProductById($maSP);
                if (!$product) {
                    throw new Exception("Sản phẩm không tồn tại!");
                }

                // Kiểm tra số lượng sản phẩm
                $sql = "SELECT SoLuong FROM chitietsanpham WHERE MaSP = ? AND MaSize = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maSP, $size, $color]);
                $availableQuantity = $stmt->fetchColumn();

                if ($availableQuantity < $quantity) {
                    throw new Exception("Sản phẩm chỉ còn " . $availableQuantity . " sản phẩm trong kho!");
                }

                // Tính tổng tiền
                $donGia = $product['GiaKhuyenMai'] < $product['DonGia'] ?
                    $product['GiaKhuyenMai'] :
                    $product['DonGia'];
                $tongTien = $donGia * $quantity;

                // Tạo hóa đơn mới
                $sql = "INSERT INTO hoadon (MaKH, TongTien, TinhTrang) VALUES (?, ?, 'Chờ xử lý')";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maKH, $tongTien]);
                $maHD = $this->db->lastInsertId();

                // Thêm chi tiết hóa đơn
                $sql = "INSERT INTO chitiethoadon (MaHD, MaSP, SoLuong, DonGia, ThanhTien, Size, MaMau, img) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $maHD,
                    $maSP,
                    $quantity,
                    $donGia,
                    $tongTien,
                    $size,
                    $color,
                    $product['AnhNen']
                ]);

                // Cập nhật số lượng sản phẩm
                $sql = "UPDATE chitietsanpham SET SoLuong = SoLuong - ? WHERE MaSP = ? AND MaSize = ? AND MaMau = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$quantity, $maSP, $size, $color]);

                // Thêm thông tin người nhận vào bảng nguoinhan
                $sql = "INSERT INTO nguoinhan (MaHD, TenNN, DiaChiNN, SDTNN) VALUES (?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$maHD, $tenNN, $diaChiNN, $sdtNN]);

                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Đặt hàng thành công!']);
            } catch (Exception $e) {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit;
    }
}
