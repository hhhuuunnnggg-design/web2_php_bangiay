<?php
require_once __DIR__ . '/../../models/client/CartModel.php';
require_once __DIR__ . '/../../models/client/UserModel.php'; // Thêm để lấy thông tin khách hàng

class CartController
{
    private $db;
    private $cartModel;
    private $userModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->cartModel = new CartModel($this->db);
        $this->userModel = new UserModel(); // Khởi tạo UserModel
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
                    $cartCount = $this->cartModel->getCartCount($maKH); // Tổng số lượng thực tế
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
        $cartTotal = $this->cartModel->getCartTotal($maKH);
        $title = "Giỏ hàng";
        include __DIR__ . '/../../views/client/page/cart.php';
    }

    public function removeFromCart()
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
            $maGH = $_POST['maGH'] ?? null;
            $maSP = $_POST['maSP'] ?? null;
            $size = $_POST['size'] ?? null;
            $maMau = $_POST['maMau'] ?? null;

            if ($maGH && $maSP && $size && $maMau) {
                $result = $this->cartModel->removeFromCart($maKH, $maGH, $maSP, $size, $maMau);
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
                    echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm!']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit;
    }

    public function getCartCount($maKH)
    {
        return $this->cartModel->getCartCount($maKH);
    }

    public function checkout()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }

        $maKH = $_SESSION['user']['MaKH'];
        $cartItems = $this->cartModel->getCartItems($maKH);
        $cartTotal = $this->cartModel->getCartTotal($maKH);
        if (empty($cartItems)) {
            header("Location: /shoeimportsystem/index.php?controller=cart&action=index");
            exit;
        }
        // Lấy thông tin khách hàng
        $userInfo = $this->userModel->getUserInfo($maKH);

        $title = "Thanh toán";
        include __DIR__ . '/../../views/client/page/checkout.php';
    }

    public function confirmCheckout()
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
            $tenNN = $_POST['tenNN'] ?? null;
            $diaChiNN = $_POST['diaChiNN'] ?? null;
            $sdtNN = $_POST['sdtNN'] ?? null;

            if ($tenNN && $diaChiNN && $sdtNN) {
                $result = $this->cartModel->processCheckout($maKH, $tenNN, $diaChiNN, $sdtNN);
                echo json_encode($result);
            } else {
                echo json_encode(['success' => false, 'message' => 'Thông tin người nhận không hợp lệ!']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit;
    }
}
