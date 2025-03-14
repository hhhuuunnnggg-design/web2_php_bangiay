<?php
require_once __DIR__ . '/../models/ImportModel.php';
require_once __DIR__ . '/../core/Auth.php';

class ImportController {
    private $importModel;
    private $auth;

    public function __construct() {
        $this->importModel = new ImportModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(11, 'view')) { // Đổi thành 11
            die("Bạn không có quyền xem danh sách phiếu nhập.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $imports = $this->importModel->getAllImports($search, $limit, $offset);
        $totalImports = $this->importModel->getTotalImports($search);
        $totalPages = ceil($totalImports / $limit);

        $title = "Quản lý phiếu nhập";
        $content_file = __DIR__ . '/../views/admin/import_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(11, 'add')) { // Đổi thành 11
            die("Bạn không có quyền thêm phiếu nhập.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = $this->auth->getCurrentUser();
            $data = [
                'MaNV' => $user['MaNV'],
                'MaSP' => $_POST['MaSP'],
                'SoLuong' => $_POST['SoLuong'],
                'DonGia' => $_POST['DonGia'],
                'TongTien' => $_POST['SoLuong'] * $_POST['DonGia'],
                'Note' => $_POST['Note'] ?: null,
                'Size' => $_POST['Size'],
                'Mau' => $_POST['Mau']
            ];
            if ($this->importModel->addImport($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm phiếu nhập thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm phiếu nhập']);
            }
            exit;
        }
    }

    public function edit() {
        if (!$this->auth->checkPermission(11, 'edit')) { // Đổi thành 11
            die("Bạn không có quyền sửa phiếu nhập.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaNV' => $_POST['MaNV'],
                'MaSP' => $_POST['MaSP'],
                'SoLuong' => $_POST['SoLuong'],
                'DonGia' => $_POST['DonGia'],
                'TongTien' => $_POST['SoLuong'] * $_POST['DonGia'],
                'Note' => $_POST['Note'] ?: null,
                'Size' => $_POST['Size'],
                'Mau' => $_POST['Mau']
            ];
            if ($this->importModel->updateImport($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật phiếu nhập thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật phiếu nhập']);
            }
            exit;
        }
        $import = $this->importModel->getImportById($id);
        $title = "Sửa phiếu nhập";
        $content_file = __DIR__ . '/../views/admin/import_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(11, 'delete')) { // Đổi thành 11
            die("Bạn không có quyền xóa phiếu nhập.");
        }
        $id = $_GET['id'];
        if ($this->importModel->deleteImport($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa phiếu nhập thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa phiếu nhập']);
        }
        exit;
    }
}