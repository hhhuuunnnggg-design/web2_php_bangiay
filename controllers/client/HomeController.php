<?php
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/client/ProductModel.php';
require_once __DIR__ . '/../../models/client/CommentModel.php';

class HomeController
{
    protected $db;
    private $categoryModel;
    private $productModel;
    private $commentModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->commentModel = new CommentModel($this->db);
    }

    public function index()
    {
        // Lấy tất cả danh mục
        $categories = $this->categoryModel->getAllCategories('', PHP_INT_MAX, 0);

        // Lấy tham số tìm kiếm từ URL (nếu có)
        $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : null;
        $selectedCategory = isset($_GET['category']) ? $_GET['category'] : null;

        $productsByCategory = [];

        if ($searchQuery) {
            // Nếu có từ khóa tìm kiếm, tìm sản phẩm theo tên và hiển thị trong giao diện riêng
            $products = $this->productModel->searchProductsByName($searchQuery);
            $productsByCategory['search'] = [
                'TenDM' => "Kết quả tìm kiếm cho '$searchQuery'",
                'products' => $products
            ];
            $title = "Kết quả tìm kiếm - $searchQuery";
            include __DIR__ . '/../../views/client/page/search_results.php';
        } else {
            // Nếu không có tìm kiếm, hiển thị sản phẩm theo danh mục như cũ
            if ($selectedCategory) {
                $products = $this->productModel->getProductsByCategory($selectedCategory, PHP_INT_MAX, 0);
                if (!empty($products)) {
                    $category = $this->categoryModel->getCategoryById($selectedCategory);
                    $productsByCategory[$selectedCategory] = [
                        'TenDM' => $category['TenDM'],
                        'products' => $products
                    ];
                }
            } else {
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
            $title = "Trang chủ";
            include __DIR__ . '/../../views/client/home.php';
        }
    }

    public function detail()
    {
        $productId = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$productId) {
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }

        $product = $this->productModel->getProductById($productId);
        if (!$product) {
            header("Location: /shoeimportsystem/index.php?controller=error&action=404");
            exit;
        }

        $productDetails = $this->productModel->getProductDetails($productId);
        $reviews = $this->commentModel->getReviewsByProductId($productId);

        $title = "Chi tiết sản phẩm - " . $product['TenSP'];
        include __DIR__ . '/../../views/client/product_detail.php';
    }
}
