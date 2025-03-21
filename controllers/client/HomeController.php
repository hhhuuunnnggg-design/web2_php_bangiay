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
        $this->commentModel = new CommentModel($this->db); // Khởi tạo CommentModel
    }
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: /shoeimportsystem/index.php?controller=home&action=index");
                exit;
            } else {
                $error = "Sai email hoặc mật khẩu!";
            }
        }
        include __DIR__ . '/../../views/client/login.php';
    }

        public function logout() {
        session_destroy();
        header("Location: /shoeimportsystem/index.php?controller=home&action=login");
        exit;
        }


    protected function model($model)
    {
        require_once __DIR__ . '/../../models/client/CommentModel.php';
        return new CommentModel($this->db);
    }


    public function index()
    {
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
        $reviews = $this->commentModel->getReviewsByProductId($productId); // Lấy danh sách đánh giá

        $title = "Chi tiết sản phẩm - " . $product['TenSP'];
        include __DIR__ . '/../../views/client/product_detail.php';
    }
}
