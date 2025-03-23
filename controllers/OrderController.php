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

        $currentUser = $this->auth->getCurrentUser(); // Giả sử trả về mảng chứa MaNV và Quyen
        $maNV = $currentUser['MaNV'] ?? null;
        $quyen = $currentUser['Quyen'] ?? null;

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        // Truyền MaNV và Quyen vào model để lọc hóa đơn
        $orders = $this->orderModel->getAllOrders($search, $limit, $offset, $maNV, $quyen);
        $totalOrders = $this->orderModel->getTotalOrders($search, $maNV, $quyen);
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
    public function assignShipper()
    {
        if (!$this->auth->checkPermission(13, 'edit')) {
            die("Bạn không có quyền gán Shipper cho hóa đơn.");
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
            $maNVGH = $_POST['MaNVGH'] ?? null;
            if (!$maNVGH) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn Shipper']);
                exit;
            }

            if ($this->orderModel->assignShipper($maHD, $maNVGH)) {
                echo json_encode(['success' => true, 'message' => 'Gán Shipper thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi gán Shipper']);
            }
            exit;
        }

        $shippers = $this->orderModel->getShippers();
        $title = "Gán Shipper cho hóa đơn - " . $maHD;
        $content_file = __DIR__ . '/../views/admin/order_assign_shipper.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }
}
