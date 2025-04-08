<?php
require_once __DIR__ . '/../models/SupplierModel.php';
require_once __DIR__ . '/../core/Auth.php';

class SupplierController
{
    private $supplierModel;
    private $auth;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(4, 'view')) {
            die("Bạn không có quyền xem danh sách nhà cung cấp.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $suppliers = $this->supplierModel->getAllSuppliers($search, $limit, $offset);
        $totalSuppliers = $this->supplierModel->getTotalSuppliers($search);
        $totalPages = ceil($totalSuppliers / $limit);

        $title = "Quản lý nhà cung cấp";
        $content_file = __DIR__ . '/../views/admin/supplier_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add()
    {
        if (!$this->auth->checkPermission(4, 'add')) {
            die("Bạn không có quyền thêm nhà cung cấp.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['TenNCC' => $_POST['TenNCC']];
            if ($this->supplierModel->addSupplier($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm nhà cung cấp thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm nhà cung cấp']);
            }
            exit;
        }
        $title = "Thêm nhà cung cấp";
        $content_file = __DIR__ . '/../views/admin/supplier/supplier_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit()
    {
        if (!$this->auth->checkPermission(4, 'edit')) {
            die("Bạn không có quyền sửa nhà cung cấp.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['TenNCC' => $_POST['TenNCC']];
            if ($this->supplierModel->updateSupplier($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật nhà cung cấp thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật nhà cung cấp']);
            }
            exit;
        }
        $supplier = $this->supplierModel->getSupplierById($id);
        $title = "Sửa nhà cung cấp";
        $content_file = __DIR__ . '/../views/admin/supplier/supplier_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete()
    {
        if (!$this->auth->checkPermission(4, 'delete')) {
            die("Bạn không có quyền xóa nhà cung cấp.");
        }
        $id = $_GET['id'];
        if ($this->supplierModel->deleteSupplier($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa nhà cung cấp thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa nhà cung cấp']);
        }
        exit;
    }

    public function import()
    {
        if (!$this->auth->checkPermission(4, 'import')) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền import nhà cung cấp']);
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
        $importedSuppliers = [];
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 2 && is_numeric($data[0])) {
                $supplierData = [
                    'MaNCC' => (int)$data[0],
                    'TenNCC' => $data[1]
                ];
                if ($this->supplierModel->importSupplier($supplierData)) {
                    $importedSuppliers[] = $supplierData;
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

        $totalSuppliers = $this->supplierModel->getTotalSuppliers('');
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Import nhà cung cấp thành công' : 'Lỗi khi import dữ liệu',
            'importedSuppliers' => $importedSuppliers,
            'totalSuppliers' => $totalSuppliers
        ]);
        exit;
    }

    public function export()
    {
        if (!$this->auth->checkPermission(4, 'export')) {
            die("Bạn không có quyền export nhà cung cấp.");
        }
        $suppliers = $this->supplierModel->getAllSuppliers('', PHP_INT_MAX, 0);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="suppliers.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['MaNCC', 'TenNCC']); // Tiêu đề CSV
        foreach ($suppliers as $supplier) {
            fputcsv($output, [$supplier['MaNCC'], $supplier['TenNCC']]);
        }
        fclose($output);
        exit;
    }

    public function getSuppliers()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $suppliers = $this->supplierModel->getAllSuppliers($search, $limit, $offset);
        $totalSuppliers = $this->supplierModel->getTotalSuppliers($search);

        echo json_encode([
            'success' => true,
            'suppliers' => $suppliers,
            'totalSuppliers' => $totalSuppliers,
            'page' => $page,
            'limit' => $limit
        ]);
        exit;
    }
}
