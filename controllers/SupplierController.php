<?php
require_once __DIR__ . '/../models/SupplierModel.php';

class SupplierController {
    private $supplierModel;

    public function __construct() {
        $this->supplierModel = new SupplierModel();
    }


    public function index() {
        $limit = 5; // Số bản ghi mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        // Đảm bảo rằng đầu ra là JSON nếu là AJAX
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // Đảm bảo trả về JSON
            // Thêm nhà cung cấp
            if (isset($_POST['add_supplier'])) {
                $id = $this->supplierModel->addSupplier($_POST['tennhacungcap'], $_POST['diachi']);
                if ($id) {
                    echo json_encode(['success' => true, 'message' => 'Thêm nhà cung cấp thành công', 'id' => $id]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi thêm nhà cung cấp']);
                }
                exit;
            }
            // Sửa nhà cung cấp
            elseif (isset($_POST['edit_supplier'])) {
                if ($this->supplierModel->updateSupplier($_POST['manhacungcap'], $_POST['tennhacungcap'], $_POST['diachi'])) {
                    echo json_encode(['success' => true, 'message' => 'Cập nhật nhà cung cấp thành công']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật nhà cung cấp']);
                }
                exit;
            }
            // Xóa nhà cung cấp
            elseif (isset($_GET['delete'])) {
                if ($this->supplierModel->deleteSupplier($_GET['delete'])) {
                    echo json_encode(['success' => true, 'message' => 'Xóa nhà cung cấp thành công']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi xóa nhà cung cấp']);
                }
                exit;
            }
        }
    
        // Hiển thị layout nếu không phải là yêu cầu AJAX
        $suppliers = $this->supplierModel->getAllSuppliers($page, $limit);
        $totalSuppliers = $this->supplierModel->getTotalSuppliers();
        $totalPages = ceil($totalSuppliers / $limit);
    
        $title = "Quản lý nhà cung cấp";
        $content_file = __DIR__ . '/../views/admin/supplier_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }
    
}