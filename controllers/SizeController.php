<?php
require_once __DIR__ . '/../models/SizeModel.php';
require_once __DIR__ . '/../core/Auth.php';

class SizeController
{
    private $sizeModel;
    private $auth;

    public function __construct()
    {
        $this->sizeModel = new SizeModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(3, 'view')) {
            die("Bạn không có quyền xem danh sách quản lý kích thước.");
        }
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

    public function add()
    {
        if (!$this->auth->checkPermission(3, 'add')) {
            die("Bạn không có quyền thêm kích thước.");
        }
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

    public function edit()
    {
        if (!$this->auth->checkPermission(3, 'edit')) {
            die("Bạn không có quyền sửa kích thước.");
        }
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

    public function delete()
    {
        if (!$this->auth->checkPermission(3, 'delete')) {
            die("Bạn không có quyền xóa kích thước.");
        }
        $id = $_GET['id'];
        if ($this->sizeModel->deleteSize($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa kích thước thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Lỗi xóa kích thước']);
        }
        exit;
    }

    public function import()
    {
        if (!$this->auth->checkPermission(3, 'import')) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền import danh mục']);
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
        $importedSizes = [];
        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if (count($data) >= 1 && is_numeric($data[0])) {
                $sizeData = ['MaSize' => (int)$data[0]];
                if ($this->sizeModel->importSize($sizeData)) {
                    $importedSizes[] = $sizeData['MaSize'];
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

        // Lấy tổng số size sau khi import để cập nhật phân trang
        $totalSizes = $this->sizeModel->getTotalSizes('');

        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Import kích thước thành công' : 'Lỗi khi import dữ liệu',
            'importedSizes' => $importedSizes,
            'totalSizes' => $totalSizes
        ]);
        exit;
    }

    // Thêm phương thức để lấy danh sách size theo trang (dùng cho cập nhật động)
    public function getSizes()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $sizes = $this->sizeModel->getAllSizes($search, $limit, $offset);
        $totalSizes = $this->sizeModel->getTotalSizes($search);

        echo json_encode([
            'success' => true,
            'sizes' => $sizes,
            'totalSizes' => $totalSizes,
            'page' => $page,
            'limit' => $limit
        ]);
        exit;
    }
    public function export()
    {
        if (!$this->auth->checkPermission(3, 'export')) {
            die("Bạn không có quyền export danh mục.");
        }
        $sizes = $this->sizeModel->getAllSizes('', PHP_INT_MAX, 0); // Lấy tất cả danh mục

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="Size.csv"');
        $output = fopen('php://output', 'w');
        fputcsv($output, ['MaSize']); // Tiêu đề CSV
        foreach ($sizes as $size) {
            fputcsv($output, [$size['MaSize']]);
        }

        fclose($output);
        exit;
    }
}
