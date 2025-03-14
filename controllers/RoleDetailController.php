<?php
require_once __DIR__ . '/../models/RoleDetailModel.php';
require_once __DIR__ . '/../core/Auth.php';

class RoleDetailController {
    private $roleDetailModel;
    private $auth;

    public function __construct() {
        $this->roleDetailModel = new RoleDetailModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(6, 'view')) { // Quyền quản lý quyền
            die("Bạn không có quyền xem chi tiết quyền.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $roleDetails = $this->roleDetailModel->getAllRoleDetails($search, $limit, $offset);
        $totalRoleDetails = $this->roleDetailModel->getTotalRoleDetails($search);
        $totalPages = ceil($totalRoleDetails / $limit);

        $title = "Quản lý chi tiết quyền";
        $content_file = __DIR__ . '/../views/admin/role_detail_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(6, 'add')) {
            die("Bạn không có quyền thêm chi tiết quyền.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'manhomquyen' => $_POST['manhomquyen'],
                'chucnang' => $_POST['chucnang'],
                'hanhdong' => $_POST['hanhdong']
            ];
            if ($this->roleDetailModel->addRoleDetail($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm chi tiết quyền thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm chi tiết quyền']);
            }
            exit;
        }
        $roles = $this->roleDetailModel->getRoles();
        $functions = $this->roleDetailModel->getFunctions();
        $title = "Thêm chi tiết quyền";
        $content_file = __DIR__ . '/../views/admin/role_detail/role_detail_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(6, 'edit')) {
            die("Bạn không có quyền sửa chi tiết quyền.");
        }
        $manhomquyen = $_GET['manhomquyen'];
        $chucnang = $_GET['chucnang'];
        $hanhdong = $_GET['hanhdong'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'manhomquyen' => $_POST['manhomquyen'],
                'chucnang' => $_POST['chucnang'],
                'hanhdong' => $_POST['hanhdong']
            ];
            if ($this->roleDetailModel->updateRoleDetail($manhomquyen, $chucnang, $hanhdong, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật chi tiết quyền thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật chi tiết quyền']);
            }
            exit;
        }
        $roleDetail = $this->roleDetailModel->getRoleDetail($manhomquyen, $chucnang, $hanhdong);
        $roles = $this->roleDetailModel->getRoles();
        $functions = $this->roleDetailModel->getFunctions();
        $title = "Sửa chi tiết quyền";
        $content_file = __DIR__ . '/../views/admin/role_detail/role_detail_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(6, 'delete')) {
            die("Bạn không có quyền xóa chi tiết quyền.");
        }
        $manhomquyen = $_GET['manhomquyen'];
        $chucnang = $_GET['chucnang'];
        $hanhdong = $_GET['hanhdong'];
        if ($this->roleDetailModel->deleteRoleDetail($manhomquyen, $chucnang, $hanhdong)) {
            echo json_encode(['success' => true, 'message' => 'Xóa chi tiết quyền thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa chi tiết quyền']);
        }
        exit;
    }
}