<?php
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../core/Auth.php';

class RoleController {
    private $roleModel;
    private $auth;

    public function __construct() {
        $this->roleModel = new RoleModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(6, 'view')) {
            die("Bạn không có quyền xem danh sách quyền.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $roles = $this->roleModel->getAllRoles($search, $limit, $offset);
        $totalRoles = $this->roleModel->getTotalRoles($search);
        $totalPages = ceil($totalRoles / $limit);

        $title = "Quản lý quyền";
        $content_file = __DIR__ . '/../views/admin/role_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(6, 'add')) {
            die("Bạn không có quyền thêm quyền.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Ten' => $_POST['Ten'],
                'MoTa' => $_POST['MoTa']
            ];
            if ($this->roleModel->addRole($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm quyền thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm quyền']);
            }
            exit;
        }
        $title = "Thêm quyền";
        $content_file = __DIR__ . '/../views/admin/role/role_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(6, 'edit')) {
            die("Bạn không có quyền sửa quyền.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'Ten' => $_POST['Ten'],
                'MoTa' => $_POST['MoTa']
            ];
            if ($this->roleModel->updateRole($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật quyền thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật quyền']);
            }
            exit;
        }
        $role = $this->roleModel->getRoleById($id);
        $title = "Sửa quyền";
        $content_file = __DIR__ . '/../views/admin/role/role_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(6, 'delete')) {
            die("Bạn không có quyền xóa quyền.");
        }
        $id = $_GET['id'];
        if ($this->roleModel->deleteRole($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa quyền thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa quyền']);
        }
        exit;
    }
}