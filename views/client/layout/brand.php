<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/shoeimportsystem/views/client/layout/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include("header.php"); ?>
    <div class="container my-4">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif ($brand): ?>
            <h2>Thương hiệu: <?php echo htmlspecialchars($brand['TenNCC']); ?></h2>

            <div class="row">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3 mb-4">
                            <div class="card h-100">
                                <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($product['AnhNen']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['TenSP']); ?></h5>
                                    <p class="card-text"><?php echo number_format($product['DonGia']); ?> VND</p>
                                    <a href="/shoeimportsystem/index.php?controller=home&action=detail&id=<?php echo $product['MaSP']; ?>" class="btn btn-primary">Xem chi tiết</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Không có sản phẩm nào thuộc thương hiệu này.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Không tìm thấy thương hiệu.</p>
        <?php endif; ?>
    </div>
    <?php include("footer.php"); ?>
</body>

</html>