<?php
require_once __DIR__ . '/../models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function index() {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $products = $this->productModel->getAllProducts($search);
        $title = "Quản lý sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php'; // Cập nhật đường dẫn
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anh = '';
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $uploadDir = 'D:/xampp/htdocs/shoeimportsystem/public/images/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['anh']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $uploadFile)) {
                    $anh = 'images/' . $fileName;
                } else {
                    die("Lỗi upload: " . $_FILES['anh']['error']);
                }
            }

            $data = [
                'masanpham' => $_POST['masanpham'],
                'tensanpham' => $_POST['tensanpham'],
                'mota' => $_POST['mota'],
                'giaban' => $_POST['giaban'],
                'soluongconlai' => $_POST['soluongconlai'],
                'size_id' => $_POST['size_id'],
                'id_mausac' => $_POST['id_mausac'],
                'manhacungcap' => $_POST['manhacungcap'],
                'anh' => $anh
            ];
            if ($this->productModel->addProduct($data)) {
                header("Location: /shoeimportsystem/public/index.php?controller=product&action=index");
                exit;
            } else {
                die("Lỗi thêm sản phẩm!");
            }
        }
        $colors = $this->productModel->getColors();
        $sizes = $this->productModel->getSizes();
        $suppliers = $this->productModel->getSuppliers();
        $title = "Thêm sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php'; // Cập nhật đường dẫn
    }

    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anh = $_POST['current_anh'];
            if (isset($_FILES['anh']) && $_FILES['anh']['error'] == 0) {
                $uploadDir = 'D:/xampp/htdocs/shoeimportsystem/public/images/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $fileName = uniqid() . '-' . basename($_FILES['anh']['name']);
                $uploadFile = $uploadDir . $fileName;
                if (move_uploaded_file($_FILES['anh']['tmp_name'], $uploadFile)) {
                    $anh = 'images/' . $fileName;
                } else {
                    die("Lỗi upload: " . $_FILES['anh']['error']);
                }
            }

            $data = [
                'tensanpham' => $_POST['tensanpham'],
                'mota' => $_POST['mota'],
                'giaban' => $_POST['giaban'],
                'soluongconlai' => $_POST['soluongconlai'],
                'size_id' => $_POST['size_id'],
                'id_mausac' => $_POST['id_mausac'],
                'manhacungcap' => $_POST['manhacungcap'],
                'anh' => $anh
            ];
            if ($this->productModel->updateProduct($id, $data)) {
                header("Location: /shoeimportsystem/public/index.php?controller=product&action=index");
                exit;
            }
        }
        $product = $this->productModel->getProductById($id);
        $colors = $this->productModel->getColors();
        $sizes = $this->productModel->getSizes();
        $suppliers = $this->productModel->getSuppliers();
        $title = "Sửa sản phẩm";
        $content_file = __DIR__ . '/../views/admin/product_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php'; // Cập nhật đường dẫn
    }

    public function delete() {
        $id = $_GET['id'];
        if ($this->productModel->deleteProduct($id)) {
            header("Location: /shoeimportsystem/public/index.php?controller=product&action=index");
            exit;
        }
    }
}