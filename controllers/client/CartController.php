<?php
require_once __DIR__ . '/../../models/client/CartModel.php';

class CartController
{
    private $db;
    private $cartModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->cartModel = new CartModel();
    }

    public function add()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            exit;
        }

        $maKH = $_SESSION['user']['MaKH'];
        $maSP = $_POST['productId'] ?? null;
        $size = $_POST['size'] ?? null;
        $maMau = $_POST['color'] ?? null;
        $soLuong = (int)($_POST['quantity'] ?? 1);

        if (!$maSP || !$size || !$maMau) {
            echo json_encode(['success' => false, 'message' => 'Thiếu thông tin sản phẩm!']);
            exit;
        }

        $success = $this->cartModel->addToCart($maKH, $maSP, $size, $maMau, $soLuong);
        echo json_encode(['success' => $success, 'message' => $success ? 'Thêm thành công!' : 'Thêm thất bại!']);
    }

    public function getCartDetails()
    {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            exit;
        }

        $maKH = $_SESSION['user']['MaKH'];
        $items = $this->cartModel->getCartDetails($maKH);
        echo json_encode(['success' => true, 'items' => $items]);
    }
}
