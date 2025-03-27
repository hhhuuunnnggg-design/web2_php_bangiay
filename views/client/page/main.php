<main>
    <!-- hero start -->
    <?php include __DIR__ . '/../layout/Hero-Start.php'; ?>
    <!-- hero end -->
    <?php if (isset($_GET['controller']) && $_GET['controller'] === 'home' && (!isset($_GET['action']) || $_GET['action'] === 'index')): ?>
        <div class="container mt-5">
            <h1 class="text-center mb-4">Sản phẩm theo danh mục</h1>
            <?php if (isset($productsByCategory) && is_array($productsByCategory) && !empty($productsByCategory)): ?>
                <?php foreach ($productsByCategory as $categoryId => $categoryData): ?>
                    <div class="category-section mb-5" id="category-<?php echo $categoryId; ?>">
                        <h2 class="mb-3"><?php echo htmlspecialchars($categoryData['TenDM']); ?></h2>
                        <div class="row">
                            <?php foreach ($categoryData['products'] as $product): ?>
                                <div class="col-md-3 mb-4">
                                    <div class="card h-100">
                                        <?php if (!empty($product['AnhNen'])): ?>
                                            <a href="/shoeimportsystem/index.php?controller=home&action=detail&id=<?php echo $product['MaSP']; ?>">
                                                <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($product['AnhNen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['TenSP']); ?>" style="height: 200px; object-fit: cover;">
                                            </a>
                                        <?php else: ?>
                                            <a href="/shoeimportsystem/index.php?controller=home&action=detail&id=<?php echo $product['MaSP']; ?>">
                                                <img src="/shoeimportsystem/public/images/default-product.jpg" class="card-img-top" alt="No image" style="height: 200px; object-fit: cover;">
                                            </a>
                                        <?php endif; ?>
                                        <div class="card-body text-center">
                                            <h5 class="card-title"><?php echo htmlspecialchars($product['TenSP']); ?></h5>
                                            <p class="card-text">
                                                <?php if ($product['GiaKhuyenMai'] < $product['DonGia']): ?>
                                                    <span class="text-danger">Giảm <?php echo number_format($product['GiamGia'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                                                    <span style="text-decoration: line-through; color: gray;"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                                                    <span class="text-success font-weight-bold"><?php echo number_format($product['GiaKhuyenMai'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                                                <?php else: ?>
                                                    <span><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if (!isset($_GET['category'])): ?>
                            <div class="text-center mt-3">
                                <a href="/shoeimportsystem/index.php?controller=home&action=index&category=<?php echo $categoryId; ?>" class="btn btn-primary">Xem thêm</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">Không có sản phẩm nào theo danh mục.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</main>