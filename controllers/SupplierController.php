<?php
require_once __DIR__ . '/../models/SupplierModel.php';

class SupplierController {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new SupplierModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5; // Số bản ghi mỗi trang
        $offset = ($page - 1) * $limit;

        $suppliers = $this->supplierModel->getAllSuppliers($search, $limit, $offset);
        $totalSuppliers = $this->supplierModel->getTotalSuppliers($search);
        $totalPages = ceil($totalSuppliers / $limit);

        $title = "Quản lý nhà cung cấp";
        $content_file = __DIR__ . '/../views/admin/supplier_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenNCC' => $_POST['TenNCC']
            ];
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

    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenNCC' => $_POST['TenNCC']
            ];
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

    public function delete() {
        $id = $_GET['id'];
        if ($this->supplierModel->deleteSupplier($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa nhà cung cấp thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa nhà cung cấp']);
        }
        exit;
    }
}