<?php
require_once __DIR__ . '/../models/EmployeeModel.php';
require_once __DIR__ . '/../core/Auth.php';

class EmployeeController
{
    private $employeeModel;
    private $auth;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
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

    public function add()
    {
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

    public function edit()
    {
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

    public function delete()
    {
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

    public function import()
    {
        if (!$this->auth->checkPermission(5, 'import')) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền import nhân viên']);
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['importFile'])) {
            echo json_encode(['success' => false, 'message' => 'Không có file được gửi lên']);
            exit;
        }

        $file = $_FILES['importFile'];
        if ($file['error'] !== UPLOAD_ERR_OK || pathinfo($file['name'], PATHINFO_EXTENSION) !== 'csv') {
            echo json_encode(['success' => false, 'message' => 'File phải là định dạng CSV và upload thành công']);
            exit;
        }

        $handle = fopen($file['tmp_name'], 'r');
        if ($handle === false) {
            echo json_encode(['success' => false, 'message' => 'Không thể đọc file CSV']);
            exit;
        }

        fgetcsv($handle); // Bỏ qua dòng tiêu đề
        $success = true;
        $importedEmployees = [];
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 6 && is_numeric($data[0]) && is_numeric($data[3]) && is_numeric($data[5])) {
                $employeeData = [
                    'MaNV' => (int)$data[0],
                    'TenNV' => $data[1],
                    'Email' => $data[2],
                    'SDT' => (int)$data[3],
                    'DiaChi' => $data[4],
                    'MatKhau' => $data[5], // Có thể mã hóa mật khẩu nếu cần
                    'Quyen' => (int)$data[6],
                    'TenQuyen' => $this->employeeModel->getRoleNameById((int)$data[6]) // Lấy tên quyền từ ID
                ];
                if ($this->employeeModel->importEmployee($employeeData)) {
                    $importedEmployees[] = $employeeData;
                } else {
                    $success = false;
                    break;
                }
            } else {
                $success = false;
                break;
            }
        }
        fclose($handle);

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Import nhân viên thành công' : 'Lỗi khi import dữ liệu',
            'importedEmployees' => $importedEmployees
        ]);
        exit;
    }

    public function export()
    {
        if (!$this->auth->checkPermission(5, 'export')) {
            die("Bạn không có quyền export nhân viên.");
        }
        $employees = $this->employeeModel->getAllEmployees('', PHP_INT_MAX, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="employees.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['MaNV', 'TenNV', 'Email', 'SDT', 'DiaChi', 'MatKhau', 'Quyen']); // Tiêu đề CSV
        foreach ($employees as $employee) {
            fputcsv($output, [
                $employee['MaNV'],
                $employee['TenNV'],
                $employee['Email'],
                $employee['SDT'],
                $employee['DiaChi'],
                $employee['MatKhau'],
                $employee['Quyen']
            ]);
        }
        fclose($output);
        exit;
    }
}
