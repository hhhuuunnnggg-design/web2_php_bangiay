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
        header('Content-Type: application/json');
        ob_end_clean();

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
                    $cartTotal = $this->cartModel->getCartTotal($maKH);
                    $_SESSION['cart_count'] = $cartCount;
                    echo json_encode([
                        'success' => true,
                        'cartCount' => $cartCount,
                        'cartTotal' => $cartTotal
                    ]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể thêm vào giỏ hàng!']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit;
    }

    public function index()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }

        $maKH = $_SESSION['user']['MaKH'];
        $cartItems = $this->cartModel->getCartItems($maKH);
        $title = "Giỏ hàng";
        include __DIR__ . '/../../views/client/page/cart.php';
    }

    public function getCartCount($maKH)
    {
        return $this->cartModel->getCartCount($maKH);
    }
}
