<?php
require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../core/Auth.php';

class OrderController
{
    private $orderModel;
    private $auth;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(13, 'view')) {
            die("Bạn không có quyền xem quản lý hóa đơn.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $orders = $this->orderModel->getAllOrders($search, $limit, $offset);
        $totalOrders = $this->orderModel->getTotalOrders($search);
        $totalPages = ceil($totalOrders / $limit);

        $title = "Quản lý hóa đơn";
        $content_file = __DIR__ . '/../views/admin/order_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function detail()
    {
        if (!$this->auth->checkPermission(13, 'view')) {
            die("Bạn không có quyền xem chi tiết hóa đơn.");
        }
        $maHD = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$maHD) {
            header("Location: /shoeimportsystem/public/index.php?controller=order&action=index");
            exit;
        }

        $order = $this->orderModel->getOrderById($maHD);
        if (!$order) {
            header("Location: /shoeimportsystem/public/index.php?controller=order&action=index");
            exit;
        }

        $orderDetails = $this->orderModel->getOrderDetails($maHD);
        $title = "Chi tiết hóa đơn - " . $maHD;
        $content_file = __DIR__ . '/../views/admin/order_detail.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit()
    {
        if (!$this->auth->checkPermission(13, 'edit')) {
            die("Bạn không có quyền chỉnh sửa hóa đơn.");
        }
        $maHD = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$maHD) {
            header("Location: /shoeimportsystem/public/index.php?controller=order&action=index");
            exit;
        }

        $order = $this->orderModel->getOrderById($maHD);
        if (!$order) {
            header("Location: /shoeimportsystem/public/index.php?controller=order&action=index");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tinhTrang = $_POST['TinhTrang'] ?? '';
            if (!in_array($tinhTrang, ['hoàn thành', 'Hủy Bỏ'])) {
                echo json_encode(['success' => false, 'message' => 'Tình trạng không hợp lệ']);
                exit;
            }

            // Logic cập nhật NgayGiao
            $ngayGiao = null; // Mặc định là NULL (Chưa giao)
            if ($tinhTrang === 'hoàn thành') {
                $ngayGiao = date('Y-m-d H:i:s'); // Thời gian hiện tại
            }

            if ($this->orderModel->updateOrderStatus($maHD, $tinhTrang, $ngayGiao)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật tình trạng thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật tình trạng']);
            }
            exit;
        }

        $title = "Sửa tình trạng hóa đơn - " . $maHD;
        $content_file = __DIR__ . '/../views/admin/order_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }
}
