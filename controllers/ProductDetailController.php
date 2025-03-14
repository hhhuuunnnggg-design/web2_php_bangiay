<?php
require_once __DIR__ . '/../models/ProductDetailModel.php';
require_once __DIR__ . '/../core/Auth.php';

class ProductDetailController {
    private $productDetailModel;
    private $auth;

    public function __construct() {
        $this->productDetailModel = new ProductDetailModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(10, 'view')) {
            die("Bạn không có quyền xem chi tiết sản phẩm.");
        }
        $search_name = isset($_GET['search_name']) ? $_GET['search_name'] : '';
        $search_color = isset($_GET['search_color']) ? $_GET['search_color'] : '';
        $search_size = isset($_GET['search_size']) ? $_GET['search_size'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $productDetails = $this->productDetailModel->getAllProductDetails($search_name, $search_color, $search_size, $limit, $offset);
        $totalProductDetails = $this->productDetailModel->getTotalProductDetails($search_name, $search_color, $search_size);
        $totalPages = ceil($totalProductDetails / $limit);

        $title = "Quản lý chi tiết sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product_detail_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }
}