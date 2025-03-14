<?php
require_once __DIR__ . '/../models/FunctionModel.php';
require_once __DIR__ . '/../core/Auth.php';

class FunctionController {
    private $functionModel;
    private $auth;

    public function __construct() {
        $this->functionModel = new FunctionModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(8, 'view')) { // Quyền quản lý quyền
            die("Bạn không có quyền xem danh sách chức năng.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $functions = $this->functionModel->getAllFunctions($search, $limit, $offset);
        $totalFunctions = $this->functionModel->getTotalFunctions($search);
        $totalPages = ceil($totalFunctions / $limit);

        $title = "Quản lý danh mục chức năng";
        $content_file = __DIR__ . '/../views/admin/function_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(8, 'add')) {
            die("Bạn không có quyền thêm chức năng.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'chucnang' => $_POST['chucnang'],
                'tenchucnang' => $_POST['tenchucnang']
            ];
            if ($this->functionModel->addFunction($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm chức năng thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm chức năng']);
            }
            exit;
        }
        $title = "Thêm chức năng";
        $content_file = __DIR__ . '/../views/admin/function/function_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(8, 'edit')) {
            die("Bạn không có quyền sửa chức năng.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'chucnang' => $_POST['chucnang'],
                'tenchucnang' => $_POST['tenchucnang']
            ];
            if ($this->functionModel->updateFunction($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật chức năng thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật chức năng']);
            }
            exit;
        }
        $function = $this->functionModel->getFunctionById($id);
        $title = "Sửa chức năng";
        $content_file = __DIR__ . '/../views/admin/function/function_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(8, 'delete')) {
            die("Bạn không có quyền xóa chức năng.");
        }
        $id = $_GET['id'];
        if ($this->functionModel->deleteFunction($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa chức năng thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa chức năng']);
        }
        exit;
    }
}