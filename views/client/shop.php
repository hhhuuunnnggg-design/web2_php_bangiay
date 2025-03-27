<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>web bán giày</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/shoeimportsystem/views/client/layout/lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="/shoeimportsystem/views/client/layout/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/shoeimportsystem/views/client/layout/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/shoeimportsystem/views/client/layout/css/shop.css" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/layout/header.php'; ?>
    <script>
        // Remove the hero section if it exists in the header
        document.addEventListener("DOMContentLoaded", function() {
            const heroSection = document.querySelector('.hero-header');
            if (heroSection) {
                heroSection.remove();
            }
        });
    </script>
    <div class="main-container" style="margin-top:220px;">

        <!-- Filter Section -->
        <div class="filter-section">
            <div>
                <a href="/shoeimportsystem/index.php?controller=home&action=index">Trang chủ</a> » Sản phẩm
            </div>

            <form method="GET" id="filterForm" action="/shoeimportsystem/index.php">
                <input type="hidden" name="controller" value="shop">
                <input type="hidden" name="action" value="index">

                <h4>Thương hiệu</h4>
                <?php foreach ($brands as $brand): ?>
                    <input type="checkbox" name="brand[]" value="<?= $brand['MaNCC'] ?>"
                        <?= in_array($brand['MaNCC'], $_GET['brand'] ?? []) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($brand['TenNCC']) ?><br>
                <?php endforeach; ?>

                <h4>Danh mục</h4>
                <?php foreach ($categories as $category): ?>
                    <input type="checkbox" name="category[]" value="<?= $category['MaDM'] ?>"
                        <?= in_array($category['MaDM'], $_GET['category'] ?? []) ? 'checked' : '' ?>>
                    <?= htmlspecialchars($category['TenDM']) ?><br>
                <?php endforeach; ?>

                <h4>Mức giá</h4>
                <input type="radio" name="price" value="1" <?= ($_GET['price'] ?? '') == 1 ? 'checked' : '' ?>> Dưới 1 triệu<br>
                <input type="radio" name="price" value="2" <?= ($_GET['price'] ?? '') == 2 ? 'checked' : '' ?>> 1 triệu - 2 triệu<br>
                <input type="radio" name="price" value="3" <?= ($_GET['price'] ?? '') == 3 ? 'checked' : '' ?>> Trên 2 triệu<br>

                <button type="submit" class="btn btn-outline-primary">Lọc sản phẩm</button>
            </form>
        </div>

        <!-- Product Section -->
        <div class="product-section">
            <div class="products">
                <?php if (empty($products)): ?>
                    <p>Không có sản phẩm nào phù hợp với bộ lọc.</p>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
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
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-4">
                    <div style="display: flex;">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Button -->
                            <li class="page-item <?= $currentPage <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage > 1 ? '/shoeimportsystem/index.php?' . http_build_query(array_merge($_GET, ['page' => $currentPage - 1])) : '#' ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                                    <a class="page-link" href="/shoeimportsystem/index.php?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= $currentPage >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= $currentPage < $totalPages ? '/shoeimportsystem/index.php?' . http_build_query(array_merge($_GET, ['page' => $currentPage + 1])) : '#' ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/layout/footer.php'; ?>
</body>

</html>

<style>
    .pagination {
        display: flex;
        justify-content: center;
        padding: 10px 0;
    }

    .pagination .page-item {
        margin: 0 5px;
    }

    .pagination .page-item .page-link {
        /* color: #007bff; */
        border: 1px solid #ddd;
        padding: 8px 12px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .pagination .page-item .page-link:hover {
        /* background-color: #007bff; */
        color: white;
    }

    .pagination .page-item.active .page-link {
        /* background-color: #007bff; */
        color: white;
        font-weight: bold;
        /* border-color: #007bff; */
    }

    .pagination .page-item.disabled .page-link {
        color: #ccc;
        pointer-events: none;
        background-color: #f8f9fa;
    }
</style>