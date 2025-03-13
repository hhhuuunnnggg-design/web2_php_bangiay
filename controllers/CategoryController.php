<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $categories = $this->categoryModel->getAllCategories($search);
        $title = "Quản lý danh mục";
        $content_file = __DIR__ . '/../views/admin/category_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
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
        $content_file = __DIR__ . '/../views/admin/category/category_add.php'; // Cập nhật đường dẫn
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
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
        $content_file = __DIR__ . '/../views/admin/category/category_edit.php'; // Cập nhật đường dẫn
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        $id = $_GET['id'];
        if ($this->categoryModel->deleteCategory($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa danh mục thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa danh mục']);
        }
        exit;
    }
}