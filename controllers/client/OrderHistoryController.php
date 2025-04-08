<?php
require_once __DIR__ . '/../../models/client/OrderModel.php';
require_once __DIR__ . '/../../core/Auth.php';

class OrderHistoryController
{
    private $orderModel;
    private $auth;
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->orderModel = new OrderModel($db);
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        $currentUser = $this->auth->getCurrentUser();
        $maKH = $currentUser['MaKH'];
        $orders = $this->orderModel->getOrdersByCustomer($maKH);
        include __DIR__ . '/../../views/client/page/order_history.php';
    }

    public function detail()
    {
        $maHD = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$maHD) {
            header("Location: /shoeimportsystem/index.php?controller=orderhistory&action=index");
            exit;
        }

        $currentUser = $this->auth->getCurrentUser();
        $maKH = $currentUser['MaKH'];
        $order = $this->orderModel->getOrderById($maHD);
        if (!$order || $order['MaKH'] != $maKH) {
            header("Location: /shoeimportsystem/index.php?controller=orderhistory&action=index");
            exit;
        }

        $orderDetails = $this->orderModel->getOrderDetails($maHD);
        include __DIR__ . '/../../views/client/page/order_history_detail.php';
    }

    public function canceled()
    {
        $currentUser = $this->auth->getCurrentUser();
        $maKH = $currentUser['MaKH'];
        $orders = $this->orderModel->getOrdersByCustomer($maKH, 'Hủy Bỏ');
        include __DIR__ . '/../../views/client/page/order_history.php';
    }

    public function shipping()
    {
        $currentUser = $this->auth->getCurrentUser();
        $maKH = $currentUser['MaKH'];
        $orders = $this->orderModel->getOrdersByCustomer($maKH, 'đang vận chuyển'); // Giả sử 'Đang giao' là trạng thái vận chuyển
        include __DIR__ . '/../../views/client/page/order_history.php';
    }
}
