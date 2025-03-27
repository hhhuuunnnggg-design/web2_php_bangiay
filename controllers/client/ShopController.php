<?php
require_once __DIR__ . '/../../models/client/ProductModel.php';
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/SupplierModel.php';

class ShopController
{
    public function index()
    {
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

        // Xử lý phân trang
        $itemsPerPage = 6; // 9 sản phẩm mỗi trang
        $currentPage = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

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

        // Lấy tổng số sản phẩm để tính số trang
        $totalProducts = count($productModel->filterProducts(
            !empty($selectedCategories) ? $selectedCategories : null,
            !empty($selectedBrands) ? $selectedBrands : null,
            $minPrice,
            $maxPrice,
            PHP_INT_MAX, // Lấy tất cả để đếm
            0
        ));
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Lọc sản phẩm với phân trang
        $products = $productModel->filterProducts(
            !empty($selectedCategories) ? $selectedCategories : null,
            !empty($selectedBrands) ? $selectedBrands : null,
            $minPrice,
            $maxPrice,
            $itemsPerPage, // Giới hạn 9 sản phẩm
            $offset
        );


        // Truyền dữ liệu sang view
        include __DIR__ . '/../../views/client/shop.php';
    }
}
