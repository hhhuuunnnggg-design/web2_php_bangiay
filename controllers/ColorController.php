<?php
require_once __DIR__ . '/../models/ColorModel.php';
require_once __DIR__ . '/../core/Auth.php';
class ColorController {
    private $colorModel;
    private $auth;

    public function __construct() {
        $this->colorModel = new ColorModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(2, 'view')) {
            die("Bạn không có quyền xem quản lý màu sắc.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5; // Số bản ghi mỗi trang
        $offset = ($page - 1) * $limit;

        $colors = $this->colorModel->getAllColors($search, $limit, $offset);
        $totalColors = $this->colorModel->getTotalColors($search);
        $totalPages = ceil($totalColors / $limit);

        $title = "Quản lý màu sắc";
        $content_file = __DIR__ . '/../views/admin/color_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(2, 'add')) {
            die("Bạn không có quyền thêm màu sắc.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaMau' => $_POST['MaMau']
            ];
            if ($this->colorModel->addColor($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm màu sắc thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm màu sắc']);
            }
            exit;
        }
        $title = "Thêm màu sắc";
        $content_file = __DIR__ . '/../views/admin/color/color_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(2, 'edit')) {
            die("Bạn không có quyền sửa màu sắc.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaMau' => $_POST['MaMau']
            ];
            if ($this->colorModel->updateColor($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật màu sắc thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật màu sắc']);
            }
            exit;
        }
        $color = $this->colorModel->getColorById($id);
        $title = "Sửa màu sắc";
        $content_file = __DIR__ . '/../views/admin/color/color_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(2, 'delete')) {
            die("Bạn không có quyền xóa màu sắc");
        }
        $id = $_GET['id'];
        if ($this->colorModel->deleteColor($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa màu sắc thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa màu sắc']);
        }
        exit;
    }
}