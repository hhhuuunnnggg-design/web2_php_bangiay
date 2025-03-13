<?php
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../core/Auth.php';

class EmployeeController {
    private $employeeModel;
    private $auth;

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(5, 'view')) {
            die("Bạn không có quyền xem danh sách nhân viên.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $employees = $this->employeeModel->getAllEmployees($search, $limit, $offset);
        $totalEmployees = $this->employeeModel->getTotalEmployees($search);
        $totalPages = ceil($totalEmployees / $limit);

        $title = "Quản lý nhân viên";
        $content_file = __DIR__ . '/../views/admin/employee_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(5, 'add')) {
            die("Bạn không có quyền thêm nhân viên.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenNV' => $_POST['TenNV'],
                'Email' => $_POST['Email'],
                'SDT' => $_POST['SDT'],
                'DiaChi' => $_POST['DiaChi'],
                'MatKhau' => $_POST['MatKhau'],
                'Quyen' => $_POST['Quyen']
            ];
            if ($this->employeeModel->addEmployee($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm nhân viên thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm nhân viên']);
            }
            exit;
        }
        $roles = $this->employeeModel->getRoles();
        $title = "Thêm nhân viên";
        $content_file = __DIR__ . '/../views/admin/employee/employee_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(5, 'edit')) {
            die("Bạn không có quyền sửa nhân viên.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenNV' => $_POST['TenNV'],
                'Email' => $_POST['Email'],
                'SDT' => $_POST['SDT'],
                'DiaChi' => $_POST['DiaChi'],
                'MatKhau' => $_POST['MatKhau'],
                'Quyen' => $_POST['Quyen']
            ];
            if ($this->employeeModel->updateEmployee($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật nhân viên thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật nhân viên']);
            }
            exit;
        }
        $employee = $this->employeeModel->getEmployeeById($id);
        $roles = $this->employeeModel->getRoles();
        $title = "Sửa nhân viên";
        $content_file = __DIR__ . '/../views/admin/employee/employee_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(5, 'delete')) {
            die("Bạn không có quyền xóa nhân viên.");
        }
        $id = $_GET['id'];
        if ($this->employeeModel->deleteEmployee($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa nhân viên thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa nhân viên']);
        }
        exit;
    }
}