<?php
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/client/ProductModel.php';

class HomeController {
    private $categoryModel;
    private $productModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        // Lấy tất cả danh mục
        $categories = $this->categoryModel->getAllCategories('', PHP_INT_MAX, 0);

        // Lấy sản phẩm theo từng danh mục
        $productsByCategory = [];
        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

        if ($selectedCategory) {
            // Nếu có danh mục được chọn, chỉ lấy sản phẩm của danh mục đó, không giới hạn
            $products = $this->productModel->getProductsByCategory($selectedCategory, PHP_INT_MAX, 0);
            if (!empty($products)) {
                $category = $this->categoryModel->getCategoryById($selectedCategory); // Hàm này cần được thêm vào CategoryModel nếu chưa có
                $productsByCategory[$selectedCategory] = [
                    'TenDM' => $category['TenDM'],
                    'products' => $products
                ];
            }
        } else {
            // Nếu không có danh mục được chọn, hiển thị 4 sản phẩm cho mỗi danh mục
            foreach ($categories as $category) {
                $products = $this->productModel->getProductsByCategory($category['MaDM'], 4, 0);
                if (!empty($products)) {
                    $productsByCategory[$category['MaDM']] = [
                        'TenDM' => $category['TenDM'],
                        'products' => $products
                    ];
                }
            }
        }

        // Gọi view
        $title = "Trang chủ";
        include __DIR__ . '/../../views/client/home.php';
    }
}