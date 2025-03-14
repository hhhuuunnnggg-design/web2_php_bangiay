<?php
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../core/Auth.php';

class CategoryController {
    private $categoryModel;
    private $auth;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(1, 'view')) {
            die("Bạn không có quyền xem danh sách danh mục.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $categories = $this->categoryModel->getAllCategories($search, $limit, $offset);
        $totalCategories = $this->categoryModel->getTotalCategories($search); // Giả định có hàm này trong CategoryModel
        $totalPages = ceil($totalCategories / $limit);

        $title = "Quản lý danh mục";
        $content_file = __DIR__ . '/../views/admin/category_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(1, 'add')) {
            die("Bạn không có quyền thêm danh mục.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenDM' => $_POST['TenDM']
            ];
            if ($this->categoryModel->addCategory($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm danh mục thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm danh mục']);
            }
            exit;
        }
        $title = "Thêm danh mục";
        $content_file = __DIR__ . '/../views/admin/category/category_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(1, 'edit')) {
            die("Bạn không có quyền sửa danh mục.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenDM' => $_POST['TenDM']
            ];
            if ($this->categoryModel->updateCategory($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật danh mục thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật danh mục']);
            }
            exit;
        }
        $category = $this->categoryModel->getCategoryById($id);
        $title = "Sửa danh mục";
        $content_file = __DIR__ . '/../views/admin/category/category_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(1, 'delete')) {
            die("Bạn không có quyền xóa danh mục.");
        }
        $id = $_GET['id'];
        if ($this->categoryModel->deleteCategory($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa danh mục thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa danh mục']);
        }
        exit;
    }
}