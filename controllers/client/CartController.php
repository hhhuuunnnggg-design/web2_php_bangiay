<?php
require_once __DIR__ . '/../../models/client/CartModel.php';

class CartController
{
    private $db;
    private $cartModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->cartModel = new CartModel($this->db);
    }

    public function addToCart()
    {
        session_start();
        header('Content-Type: application/json'); // Đảm bảo header JSON

        if (!isset($_SESSION['user'])) {
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $maKH = $_SESSION['user']['MaKH'];
            $maSP = $_POST['productId'] ?? null;
            $soLuong = $_POST['quantity'] ?? 1;
            $size = $_POST['size'] ?? null;
            $maMau = $_POST['color'] ?? null;

            if ($maSP && $size && $maMau) {
                $result = $this->cartModel->addToCart($maKH, $maSP, $soLuong, $size, $maMau);
                if ($result) {
                    $cartCount = $this->cartModel->getCartCount($maKH);
                    $_SESSION['cart_count'] = $cartCount;
                    echo json_encode(['success' => true, 'cartCount' => $cartCount]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể thêm vào giỏ hàng!']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit; // Đảm bảo dừng xử lý
    }
}
