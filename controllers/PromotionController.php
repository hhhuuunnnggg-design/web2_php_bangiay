<?php
require_once __DIR__ . '/../models/PromotionModel.php';
require_once __DIR__ . '/../core/Auth.php';

class PromotionController {
    private $promotionModel;
    private $auth;

    public function __construct() {
        $this->promotionModel = new PromotionModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(9, 'view')) { // Quyền quản lý khuyến mãi
            die("Bạn không có quyền xem danh sách khuyến mãi.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $promotions = $this->promotionModel->getAllPromotions($search, $limit, $offset);
        $totalPromotions = $this->promotionModel->getTotalPromotions($search);
        $totalPages = ceil($totalPromotions / $limit);

        $title = "Quản lý khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/promotion_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(9, 'add')) {
            die("Bạn không có quyền thêm khuyến mãi.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenKM' => $_POST['TenKM'],
                'MoTa' => $_POST['MoTa'] ?: null,
                'KM_PT' => $_POST['KM_PT'] ?: null,
                'TienKM' => $_POST['TienKM'] ?: null,
                'NgayBD' => $_POST['NgayBD'],
                'NgayKT' => $_POST['NgayKT']
            ];
            if ($this->promotionModel->addPromotion($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm khuyến mãi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm khuyến mãi']);
            }
            exit;
        }
        $title = "Thêm khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/promotion/promotion_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(9, 'edit')) {
            die("Bạn không có quyền sửa khuyến mãi.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenKM' => $_POST['TenKM'],
                'MoTa' => $_POST['MoTa'] ?: null,
                'KM_PT' => $_POST['KM_PT'] ?: null,
                'TienKM' => $_POST['TienKM'] ?: null,
                'NgayBD' => $_POST['NgayBD'],
                'NgayKT' => $_POST['NgayKT']
            ];
            if ($this->promotionModel->updatePromotion($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật khuyến mãi thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật khuyến mãi']);
            }
            exit;
        }
        $promotion = $this->promotionModel->getPromotionById($id);
        $title = "Sửa khuyến mãi";
        $content_file = __DIR__ . '/../views/admin/promotion/promotion_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(9, 'delete')) {
            die("Bạn không có quyền xóa khuyến mãi.");
        }
        $id = $_GET['id'];
        if ($this->promotionModel->deletePromotion($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa khuyến mãi thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa khuyến mãi']);
        }
        exit;
    }
}