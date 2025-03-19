<?php
require_once __DIR__ . '/../../models/CategoryModel.php';
require_once __DIR__ . '/../../models/client/ProductModel.php';
require_once __DIR__ . '/../../controllers/client/CommentController.php';

class HomeController {
    protected $db;
    private $categoryModel;
    private $productModel;

    public function __construct($db) {
        $this->db = $db;
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
    }

    
    
    protected function model($model) {
        require_once __DIR__ . '/../../models/client/CommentModel.php';
        return new CommentModel($this->db);
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
    public function detail() {
        // Lấy ID sản phẩm từ URL, tham số id sẽ được truyền từ đây vào
        $productId = isset($_GET['id']) ? $_GET['id'] : null;
        if (!$productId) {
            // Redirect hoặc hiển thị lỗi nếu không có ID sản phẩm
            header("Location: /shoeimportsystem/index.php?controller=home&action=index");
            exit;
        }
    
        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($productId); // Hàm này cần được thêm vào ProductModel
        if (!$product) {
            // Xử lý trường hợp không tìm thấy sản phẩm
            header("Location: /shoeimportsystem/index.php?controller=error&action=404");
            exit;
        }
    
        // Lấy chi tiết kích thước và màu sắc
        $productDetails = $this->productModel->getProductDetails($productId); // Hàm này cần được thêm vào ProductModel

        $commentController = new CommentController($this->db);
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            if ($commentController->addComment($productId)) {
                // Thêm thành công
                header("Location: /shoeimportsystem/index.php?controller=product&action=detail&id=$productId");
                exit;
            } else {
                // Thêm thất bại
                echo "Lỗi khi thêm bình luận.";
            }
        }
    
        // Gọi view
        $title = "Chi tiết sản phẩm - " . $product['TenSP'];
        include __DIR__ . '/../../views/client/product_detail.php';
    }
}