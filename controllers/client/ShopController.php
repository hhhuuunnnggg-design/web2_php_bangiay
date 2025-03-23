<?php
require_once __DIR__ . '/../../models/client/ProductModel.php';
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/SupplierModel.php';

class ShopController {
    public function index() {
        $productModel = new ProductModel();
        $categoryModel = new CategoryModel();
        $supplierModel = new SupplierModel();

        // Lấy brands và categories để hiển thị filter
        $brands = $supplierModel->getAllSuppliers();
        $categories = $categoryModel->getAllCategories();

        // Lấy filter từ GET
        $selectedBrands = $_GET['brand'] ?? [];
        $selectedCategories = $_GET['category'] ?? [];
        $priceFilter = $_GET['price'] ?? null;

        // Chuyển đổi price filter thành min-max
        $minPrice = null;
        $maxPrice = null;
        if ($priceFilter == 1) {
            $maxPrice = 1000000;
        } elseif ($priceFilter == 2) {
            $minPrice = 1000000;
            $maxPrice = 2000000;
        } elseif ($priceFilter == 3) {
            $minPrice = 2000000;
        }

        // Lọc sản phẩm
        $products = $productModel->filterProducts(
            !empty($selectedCategories) ? $selectedCategories : null,
            !empty($selectedBrands) ? $selectedBrands : null,
            $minPrice,
            $maxPrice
        );
       

        // Truyền dữ liệu sang view
        include __DIR__ . '/../../views/client/shop.php';
    }
}
?>