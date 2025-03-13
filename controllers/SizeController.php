<?php
require_once __DIR__ . '/../models/SizeModel.php';

class SizeController {
    private $sizeModel;

    public function __construct() {
        $this->sizeModel = new SizeModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5; // Số bản ghi mỗi trang
        $offset = ($page - 1) * $limit;

        $sizes = $this->sizeModel->getAllSizes($search, $limit, $offset);
        $totalSizes = $this->sizeModel->getTotalSizes($search);
        $totalPages = ceil($totalSizes / $limit);

        $title = "Quản lý kích thước";
        $content_file = __DIR__ . '/../views/admin/size_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaSize' => $_POST['MaSize']
            ];
            if ($this->sizeModel->addSize($data)) {
                echo json_encode(['success' => true, 'message' => 'Thêm kích thước thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm kích thước']);
            }
            exit;
        }
        $title = "Thêm kích thước";
        $content_file = __DIR__ . '/../views/admin/size/size_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaSize' => $_POST['MaSize']
            ];
            if ($this->sizeModel->updateSize($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật kích thước thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật kích thước']);
            }
            exit;
        }
        $size = $this->sizeModel->getSizeById($id);
        $title = "Sửa kích thước";
        $content_file = __DIR__ . '/../views/admin/size/size_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        $id = $_GET['id'];
        if ($this->sizeModel->deleteSize($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa kích thước thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa kích thước']);
        }
        exit;
    }
}