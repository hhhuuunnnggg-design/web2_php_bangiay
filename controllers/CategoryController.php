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
        $totalCategories = $this->categoryModel->getTotalCategories($search);
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

    public function import() {
        if (!$this->auth->checkPermission(1, 'add')) {
            die("Bạn không có quyền import danh mục.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['importFile'])) {
            $file = $_FILES['importFile'];
            if ($file['type'] !== 'text/csv') {
                echo json_encode(['success' => false, 'message' => 'File phải là định dạng CSV']);
                exit;
            }

            $handle = fopen($file['tmp_name'], 'r');
            if ($handle !== false) {
                fgetcsv($handle); // Bỏ qua dòng tiêu đề
                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if (count($data) >= 2) { // Giả sử CSV có ít nhất 2 cột: MaDM, TenDM
                        $categoryData = [
                            'MaDM' => $data[0], // MaDM từ cột 1
                            'TenDM' => $data[1] // TenDM từ cột 2
                        ];
                        $this->categoryModel->importCategory($categoryData);
                    }
                }
                fclose($handle);
                echo json_encode(['success' => true, 'message' => 'Import danh mục thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể đọc file CSV']);
            }
            exit;
        }
    }

    public function export() {
        if (!$this->auth->checkPermission(1, 'view')) {
            die("Bạn không có quyền export danh mục.");
        }
        $categories = $this->categoryModel->getAllCategories('', PHP_INT_MAX, 0); // Lấy tất cả danh mục

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="danhmuc.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['MaDM', 'TenDM']); // Tiêu đề CSV

        foreach ($categories as $category) {
            fputcsv($output, [$category['MaDM'], $category['TenDM']]);
        }

        fclose($output);
        exit;
    }
}