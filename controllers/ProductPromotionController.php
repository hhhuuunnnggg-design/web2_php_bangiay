<?php
require_once __DIR__ . '/../models/ProductPromotionModel.php';
require_once __DIR__ . '/../core/Auth.php';

class ProductPromotionController
{
    private $productPromotionModel;
    private $auth;

    public function __construct()
    {
        $this->productPromotionModel = new ProductPromotionModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(9, 'view')) {
            die("Bạn không có quyền xem danh sách sản phẩm khuyến mãi.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $productPromotions = $this->productPromotionModel->getAllProductPromotions($search, $limit, $offset);
        $totalProductPromotions = $this->productPromotionModel->getTotalProductPromotions($search);
        $totalPages = ceil($totalProductPromotions / $limit);

        $title = "Quản lý sản phẩm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/product_promotion_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add()
    {
        if (!$this->auth->checkPermission(9, 'add')) {
            die("Bạn không có quyền thêm sản phẩm khuyến mãi.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaSP' => $_POST['MaSP'],
                'MaKM' => $_POST['MaKM']
            ];
            if ($this->productPromotionModel->addProductPromotion($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm khuyến mãi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm sản phẩm khuyến mãi']);
            }
            exit;
        }
        $products = $this->productPromotionModel->getProducts();
        $promotions = $this->productPromotionModel->getPromotions();
        $title = "Thêm sản phẩm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/product_promotion_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit()
    {
        if (!$this->auth->checkPermission(9, 'edit')) {
            die("Bạn không có quyền sửa sản phẩm khuyến mãi.");
        }
        $maSP = $_GET['maSP'];
        $maKM = $_GET['maKM'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaSP' => $_POST['MaSP'],
                'MaKM' => $_POST['MaKM']
            ];
            if ($this->productPromotionModel->updateProductPromotion($maSP, $maKM, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật sản phẩm khuyến mãi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật sản phẩm khuyến mãi']);
            }
            exit;
        }
        $productPromotion = $this->productPromotionModel->getProductPromotion($maSP, $maKM);
        $products = $this->productPromotionModel->getProducts();
        $promotions = $this->productPromotionModel->getPromotions();
        $title = "Sửa sản phẩm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/product_promotion_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete()
    {
        if (!$this->auth->checkPermission(9, 'delete')) {
            die("Bạn không có quyền xóa sản phẩm khuyến mãi.");
        }
        $maSP = $_GET['maSP'];
        $maKM = $_GET['maKM'];
        if ($this->productPromotionModel->deleteProductPromotion($maSP, $maKM)) {
            echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm khuyến mãi thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa sản phẩm khuyến mãi']);
        }
        exit;
    }
}
