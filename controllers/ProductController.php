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
        require_once __DIR__ . '/../views/admin/product_index.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'masanpham' => $_POST['masanpham'],
                'tensanpham' => $_POST['tensanpham'],
                'mota' => $_POST['mota'],
                'giaban' => $_POST['giaban'],
                'soluongconlai' => $_POST['soluongconlai'],
                'size_id' => $_POST['size_id'],
                'id_mausac' => $_POST['id_mausac'],
                'manhacungcap' => $_POST['manhacungcap']
            ];
            if ($this->productModel->addProduct($data)) {
                header("Location: /shoeimportsystem/public/index.php?controller=product&action=index");
                exit;
            }
        }
        $colors = $this->productModel->getColors();
        $sizes = $this->productModel->getSizes();
        $suppliers = $this->productModel->getSuppliers();
        require_once __DIR__ . '/../views/admin/product_add.php';
    }

    public function edit() {
        $id = $_GET['id'];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'tensanpham' => $_POST['tensanpham'],
                'mota' => $_POST['mota'],
                'giaban' => $_POST['giaban'],
                'soluongconlai' => $_POST['soluongconlai'],
                'size_id' => $_POST['size_id'],
                'id_mausac' => $_POST['id_mausac'],
                'manhacungcap' => $_POST['manhacungcap']
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
        require_once __DIR__ . '/../views/admin/product_edit.php';
    }

    public function delete() {
        $id = $_GET['id'];
        if ($this->productModel->deleteProduct($id)) {
            header("Location: /shoeimportsystem/public/index.php?controller=product&action=index");
            exit;
        }
    }
}