<?php
require_once __DIR__ . '/../models/StatisticsModel.php';
require_once __DIR__ . '/../core/Auth.php';

class StatisticsController
{
    private $statisticsModel;
    private $auth;

    public function __construct()
    {
        $this->statisticsModel = new StatisticsModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function topCustomers()
    {
        if (!$this->auth->checkPermission(13, 'view')) {
            die("Bạn không có quyền xem thống kê khách hàng.");
        }

        $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : null;
        $endDate = isset($_POST['end_date']) ? $_POST['end_date'] : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $startDate && $endDate) {
            $topCustomers = $this->statisticsModel->getTopCustomers($startDate, $endDate);
            echo json_encode(['success' => true, 'data' => $topCustomers]);
            exit;
        }

        $title = "Thống kê 5 khách hàng mua nhiều nhất";
        $content_file = __DIR__ . '/../views/admin/statistics/top_customers.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function orderDetails()
    {
        if (!$this->auth->checkPermission(13, 'view')) {
            die("Bạn không có quyền xem chi tiết hóa đơn.");
        }

        $maHD = isset($_GET['id']) ? $_GET['id'] : null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $maHD) {
            $orderDetails = $this->statisticsModel->getOrderDetails($maHD);
            echo json_encode(['success' => true, 'data' => $orderDetails]);
            exit;
        }
    }
}
