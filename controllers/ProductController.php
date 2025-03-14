<?php
require_once __DIR__ . '/../models/ProductModel.php';
require_once __DIR__ . '/../core/Auth.php';

class ProductController {
    private $productModel;
    private $auth;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index() {
        if (!$this->auth->checkPermission(10, 'view')) {
            die("Bạn không có quyền xem danh sách sản phẩm.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $price_min = isset($_GET['price_min']) && $_GET['price_min'] !== '' ? (float)$_GET['price_min'] : null;
        $price_max = isset($_GET['price_max']) && $_GET['price_max'] !== '' ? (float)$_GET['price_max'] : null;
        $low_stock = isset($_GET['low_stock']) && $_GET['low_stock'] == '1';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $products = $this->productModel->getAllProducts($search, $price_min, $price_max, $low_stock, $limit, $offset);
        $totalProducts = $this->productModel->getTotalProducts($search, $price_min, $price_max, $low_stock);
        $totalPages = ceil($totalProducts / $limit);

        $title = "Quản lý sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add() {
        if (!$this->auth->checkPermission(10, 'add')) {
            die("Bạn không có quyền thêm sản phẩm.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anh_nen = '';
            if (isset($_FILES['AnhNen']) && $_FILES['AnhNen']['error'] == 0) {
                $uploadDir = 'D:/xampp/htdocs/shoeimportsystem/public/images/anh_nen/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['AnhNen']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['AnhNen']['tmp_name'], $uploadFile)) {
                    $anh_nen = 'images/anh_nen/' . $fileName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi upload ảnh']);
                    exit;
                }
            }
    
            $data = [
                'TenSP' => $_POST['TenSP'],
                'MaDM' => $_POST['MaDM'] ?: null,
                'MaNCC' => $_POST['MaNCC'],
                'MoTa' => $_POST['MoTa'] ?: null,
                'DonGia' => $_POST['DonGia'],
                'AnhNen' => $anh_nen
            ];
            $sizes = isset($_POST['MaSize']) && is_array($_POST['MaSize']) ? $_POST['MaSize'] : [];
            $colors = isset($_POST['MaMau']) && is_array($_POST['MaMau']) ? $_POST['MaMau'] : [];
    
            // Debug: Kiểm tra dữ liệu nhận được
            error_log("Sizes: " . json_encode($sizes));
            error_log("Colors: " . json_encode($colors));
    
            if (empty($sizes) || empty($colors)) {
                echo json_encode(['success' => false, 'message' => 'Vui lòng chọn ít nhất 1 size và 1 màu']);
                exit;
            }
    
            if ($this->productModel->addProduct($data, $sizes, $colors)) {
                echo json_encode(['success' => true, 'message' => 'Thêm sản phẩm thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi thêm sản phẩm']);
            }
            exit;
        }
        $categories = $this->productModel->getCategories();
        $suppliers = $this->productModel->getSuppliers();
        $sizes = $this->productModel->getSizes();
        $colors = $this->productModel->getColors();
        $title = "Thêm sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product/product_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit() {
        if (!$this->auth->checkPermission(10, 'edit')) {
            die("Bạn không có quyền sửa sản phẩm.");
        }
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anh_nen = $_POST['current_AnhNen'];
            if (isset($_FILES['AnhNen']) && $_FILES['AnhNen']['error'] == 0) {
                $uploadDir = 'D:/xampp/htdocs/shoeimportsystem/public/images/anh_nen/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['AnhNen']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['AnhNen']['tmp_name'], $uploadFile)) {
                    $anh_nen = 'images/anh_nen/' . $fileName;
                } else {
                    echo json_encode(['success' => false, 'message' => 'Lỗi upload ảnh']);
                    exit;
                }
            }

            $data = [
                'TenSP' => $_POST['TenSP'],
                'MaDM' => $_POST['MaDM'] ?: null,
                'MaNCC' => $_POST['MaNCC'],
                'MoTa' => $_POST['MoTa'] ?: null,
                'DonGia' => $_POST['DonGia'],
                'AnhNen' => $anh_nen
            ];
            if ($this->productModel->updateProduct($id, $data)) {
                echo json_encode(['success' => true, 'message' => 'Cập nhật sản phẩm thành công']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi cập nhật sản phẩm']);
            }
            exit;
        }
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getCategories();
        $suppliers = $this->productModel->getSuppliers();
        $title = "Sửa sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product/product_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function delete() {
        if (!$this->auth->checkPermission(10, 'delete')) {
            die("Bạn không có quyền xóa sản phẩm.");
        }
        $id = $_GET['id'];
        if ($this->productModel->deleteProduct($id)) {
            echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm vì số lượng không phải 0']);
        }
        exit;
    }
}