<?php
require_once __DIR__ . '/../models/RoleModel.php';
require_once __DIR__ . '/../core/Auth.php';

class RoleController
{
    private $roleModel;
    private $auth;

    public function __construct()
    {
        $this->roleModel = new RoleModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
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

    public function add()
    {
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

    public function edit()
    {
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

    public function delete()
    {
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

    public function import()
    {
        if (!$this->auth->checkPermission(6, 'import')) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền import quyền']);
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
        $importedRoles = [];
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 3 && is_numeric($data[0])) {
                $roleData = [
                    'id' => (int)$data[0],
                    'Ten' => $data[1],
                    'MoTa' => $data[2]
                ];
                if ($this->roleModel->importRole($roleData)) {
                    $importedRoles[] = $roleData;
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
            'message' => $success ? 'Import quyền thành công' : 'Lỗi khi import dữ liệu',
            'importedRoles' => $importedRoles
        ]);
        exit;
    }

    public function export()
    {
        if (!$this->auth->checkPermission(6, 'export')) {
            die("Bạn không có quyền export quyền.");
        }
        $roles = $this->roleModel->getAllRoles('', PHP_INT_MAX, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="roles.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Ten', 'MoTa']); // Tiêu đề CSV
        foreach ($roles as $role) {
            fputcsv($output, [$role['id'], $role['Ten'], $role['MoTa']]);
        }
        fclose($output);
        exit;
    }
}
