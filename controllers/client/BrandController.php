<?php
require_once __DIR__ . '/../../models/client/SupplierModel.php';
require_once __DIR__ . '/../../models/client/ProductModel.php';

class BrandController {
    
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hiển thị sản phẩm theo thương hiệu
    public function index() {
        $brand_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $supplier = new Supplier($this->db);
        $brand = $supplier->getBrandById($brand_id);

        $product = new ProductModel($this->db);
        $products = $product->getProductsByBrand($brand_id);

        include __DIR__ . '/../../views/client/layout/brand.php';
    }

    // API trả danh sách thương hiệu dạng JSON
    public function getBrands() {
        $supplier = new Supplier($this->db);
        $brands = $supplier->getAllBrands(); // Viết thêm hàm này trong model Supplier

        header('Content-Type: application/json');
        echo json_encode($brands);
        exit;
    }

    // API trả sản phẩm theo thương hiệu (JSON)
    public function getProductsByBrand() {
        $brand_id = isset($_GET['id']) ? $_GET['id'] : 0;
        $product = new ProductModel($this->db);
        $products = $product->getProductsByBrand($brand_id);

        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }
}
?>
