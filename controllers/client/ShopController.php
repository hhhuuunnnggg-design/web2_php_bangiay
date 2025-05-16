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
        $brands = $supplierModel->getAllSuppliers(); // nhà cung cấp
        $categories = $categoryModel->getAllCategories(); // danh mục

        // Lấy filter từ GET
        $selectedBrands = $_GET['brand'] ?? [];
        $selectedCategories = $_GET['category'] ?? [];
        $priceFilter = $_GET['price'] ?? null;

        // Xử lý phân trang
        $itemsPerPage = 6;
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
            PHP_INT_MAX,
            0
        ));
        $totalPages = ceil($totalProducts / $itemsPerPage);

        // Đảm bảo currentPage không vượt quá totalPages
        if ($currentPage > $totalPages) {
            $currentPage = 1;
            $offset = 0;
        }

        // Lọc sản phẩm với phân trang
        $products = $productModel->filterProducts(
            !empty($selectedCategories) ? $selectedCategories : null,
            !empty($selectedBrands) ? $selectedBrands : null,
            $minPrice,
            $maxPrice,
            $itemsPerPage,
            $offset
        );

        // Truyền dữ liệu sang view
        include __DIR__ . '/../../views/client/shop.php';
    }

    public function filter()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel = new ProductModel();

            // Lấy filter từ POST
            $selectedBrands = $_POST['brand'] ?? [];
            $selectedCategories = $_POST['category'] ?? [];
            $priceFilter = $_POST['price'] ?? null;
            $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;

            // Xử lý phân trang
            $itemsPerPage = 6;
            $offset = ($page - 1) * $itemsPerPage;

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
                PHP_INT_MAX,
                0
            ));
            $totalPages = ceil($totalProducts / $itemsPerPage);

            // Đảm bảo page không vượt quá totalPages
            if ($page > $totalPages) {
                $page = 1;
                $offset = 0;
            }

            // Lọc sản phẩm với phân trang
            $products = $productModel->filterProducts(
                !empty($selectedCategories) ? $selectedCategories : null,
                !empty($selectedBrands) ? $selectedBrands : null,
                $minPrice,
                $maxPrice,
                $itemsPerPage,
                $offset
            );

            // Tạo HTML cho sản phẩm
            ob_start();
            if (empty($products)) {
                echo '<p>Không có sản phẩm nào phù hợp với bộ lọc.</p>';
            } else {
                foreach ($products as $product) {
?>
                    <div class="product-card">
                        <a href="/shoeimportsystem/index.php?controller=home&action=detail&id=<?= $product['MaSP'] ?>">
                            <img src="/shoeimportsystem/public/<?= htmlspecialchars($product['AnhNen']) ?>" alt="<?= htmlspecialchars($product['TenSP']) ?>">
                            <h4><?= htmlspecialchars($product['TenSP']) ?></h4>
                            <p>Danh mục: <?php echo htmlspecialchars($product['TenDM']); ?></p>
                            <p>Thương hiệu: <?php echo htmlspecialchars($product['TenNCC']); ?></p>
                            <p class="price">
                                <?php if ($product['GiaKhuyenMai'] < $product['DonGia']): ?>
                                    <span class="text-danger">Giảm <?php echo number_format($product['GiamGia'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                                    <span style="text-decoration: line-through; color: gray;"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                                    <span class="text-success font-weight-bold"><?php echo number_format($product['GiaKhuyenMai'], 0, ',', '.') . ' VNĐ'; ?></span>
                                <?php else: ?>
                                    <span><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                                <?php endif; ?>
                            </p>
                        </a>
                    </div>
                <?php
                }
            }
            $productsHtml = ob_get_clean();

            // Tạo HTML cho phân trang
            ob_start();
            if ($totalPages > 1) {
                ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <div style="display: flex;">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="#" data-page="<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <?php
                            // Hiển thị tối đa 5 trang
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $startPage + 4);
                            if ($endPage - $startPage < 4) {
                                $startPage = max(1, $endPage - 4);
                            }

                            // Hiển thị nút trang đầu nếu cần
                            if ($startPage > 1) {
                                echo '<li class="page-item"><a class="page-link" href="#" data-page="1">1</a></li>';
                                if ($startPage > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }

                            // Hiển thị các trang
                            for ($i = $startPage; $i <= $endPage; $i++) {
                            ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="#" data-page="<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php
                            }

                            // Hiển thị nút trang cuối nếu cần
                            if ($endPage < $totalPages) {
                                if ($endPage < $totalPages - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="#" data-page="' . $totalPages . '">' . $totalPages . '</a></li>';
                            }
                            ?>

                            <!-- Next Button -->
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="#" data-page="<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
<?php
            }
            $paginationHtml = ob_get_clean();

            // Trả về JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'products' => $productsHtml,
                'pagination' => $paginationHtml,
                'currentPage' => $page,
                'totalPages' => $totalPages
            ]);
            exit;
        }
    }
}
