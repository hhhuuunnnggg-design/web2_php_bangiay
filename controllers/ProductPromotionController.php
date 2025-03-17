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
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
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
            error_log("POST data: " . print_r($_POST, true)); // Debug dữ liệu nhận được
            if (!isset($_POST['MaSP']) || !isset($_POST['MaKM'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu MaSP hoặc MaKM']);
                exit;
            }

            $data = [
                'MaSP' => (int)$_POST['MaSP'],
                'MaKM' => (int)$_POST['MaKM']
            ];

            try {
                if ($this->productPromotionModel->addProductPromotion($data)) {
                    echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm khuyến mãi thành công']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể thêm sản phẩm khuyến mãi']);
                }
            } catch (Exception $e) {
                error_log("Error in addProductPromotion: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
            }
            exit;
        }
        $products = $this->productPromotionModel->getProducts();
        $promotions = $this->productPromotionModel->getPromotions();
        $title = "Thêm sản phẩm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/product_promotion/product_promotion_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit()
    {
        if (!$this->auth->checkPermission(9, 'edit')) {
            die("Bạn không có quyền sửa sản phẩm khuyến mãi.");
        }
        $maSP = isset($_GET['maSP']) ? (int)$_GET['maSP'] : null;
        $maKM = isset($_GET['maKM']) ? (int)$_GET['maKM'] : null;

        if (!$maSP || !$maKM) {
            die("Thiếu tham số maSP hoặc maKM.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST data: " . print_r($_POST, true)); // Debug dữ liệu nhận được
            if (!isset($_POST['MaSP']) || !isset($_POST['MaKM'])) {
                echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu MaSP hoặc MaKM']);
                exit;
            }

            $data = [
                'MaSP' => (int)$_POST['MaSP'],
                'MaKM' => (int)$_POST['MaKM']
            ];

            try {
                if ($this->productPromotionModel->updateProductPromotion($maSP, $maKM, $data)) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật sản phẩm khuyến mãi thành công']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Không thể cập nhật sản phẩm khuyến mãi']);
                }
            } catch (Exception $e) {
                error_log("Error in updateProductPromotion: " . $e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
            }
            exit;
        }
        $productPromotion = $this->productPromotionModel->getProductPromotion($maSP, $maKM);
        if (!$productPromotion) {
            die("Không tìm thấy sản phẩm khuyến mãi.");
        }
        $products = $this->productPromotionModel->getProducts();
        $promotions = $this->productPromotionModel->getPromotions();
        $title = "Sửa sản phẩm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/product_promotion/product_promotion_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete()
    {
        if (!$this->auth->checkPermission(9, 'delete')) {
            die("Bạn không có quyền xóa sản phẩm khuyến mãi.");
        }
        $maSP = isset($_GET['maSP']) ? (int)$_GET['maSP'] : null;
        $maKM = isset($_GET['maKM']) ? (int)$_GET['maKM'] : null;

        if (!$maSP || !$maKM) {
            echo json_encode(['success' => false, 'message' => 'Thiếu tham số maSP hoặc maKM']);
            exit;
        }

        try {
            if ($this->productPromotionModel->deleteProductPromotion($maSP, $maKM)) {
                echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm khuyến mãi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm khuyến mãi']);
            }
        } catch (Exception $e) {
            error_log("Error in deleteProductPromotion: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
        }
        exit;
    }
}
