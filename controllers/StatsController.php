<?php
require_once __DIR__ . '/../models/StatsModel.php';
require_once __DIR__ . '/../core/Auth.php';

class StatsController
{
    private $statsModel;
    private $auth;

    public function __construct()
    {
        $this->statsModel = new StatsModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(12, 'view')) {
            die("Bạn không có quyền xem thống kê.");
        }

        $revenueStats = $this->statsModel->getRevenueStats();
        $topProducts = $this->statsModel->getTopProducts();
        $employeeStats = $this->statsModel->getEmployeeStats();

        $title = "Thống kê";
        $content_file = __DIR__ . '/../views/admin/stats_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }
}
