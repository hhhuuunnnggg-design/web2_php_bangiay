<?php
require_once __DIR__ . '/../../models/client/SupplierModel.php';
require_once __DIR__ . '/../../models/client/ProductModel.php';

class BrandController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $brand_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $supplier = new Supplier();
        $brand = $supplier->getBrandById($brand_id);

        if (!$brand || $brand_id <= 0) {
            $error = "Thương hiệu không tồn tại hoặc ID không hợp lệ!";
            include __DIR__ . '/../../views/client/layout/brand.php';
            return;
        }

        $product = new ProductModel($this->db);
        $products = $product->getProductsByBrand($brand_id);

        include __DIR__ . '/../../views/client/layout/brand.php';
    }
    // public function index()
    // {
    //     $brand_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    //     $supplier = new Supplier();
    //     $brand = $supplier->getBrandById($brand_id);
    //     echo "Brand ID: $brand_id<br>";
    //     echo "Brand tên thương hiệu: " . htmlspecialchars($brand['TenNCC'], ENT_QUOTES, 'UTF-8') . "<br>";

    //     var_dump($brand);
    //     die;
    // }

    public function getBrands()
    {
        $supplier = new Supplier();
        $brands = $supplier->getAllBrands();

        header('Content-Type: application/json');
        echo json_encode($brands);
        exit;
    }

    public function getProductsByBrand()
    {
        $brand_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = new ProductModel($this->db);
        $products = $product->getProductsByBrand($brand_id);

        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }
}
