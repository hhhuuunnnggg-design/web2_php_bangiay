<?php
session_start();
require_once __DIR__ . '/../../../models/client/SupplierModel.php';
$supplierModel = new Supplier();
$brands = $supplierModel->getAllBrands();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>web bán giày</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
    <link href="/shoeimportsystem/views/client/layout/css/style.css" rel="stylesheet">
    <link href="/shoeimportsystem/views/client/layout/js/main.js" rel="stylesheet">
</head>

<body>
    

        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container d-lg-block d-none bg-primary topbar">
                <div class="d-flex justify-content-between">
                    <div class="ps-2 top-info">
                        <small class="me-3"><i class="text-secondary fa-map-marker-alt fas me-2"></i> <a href="#" class="text-white">Đại học Sài Gòn</a></small>
                        <small class="me-3"><i class="text-secondary fa-envelope fas me-2"></i><a href="#" class="text-white">nguyendinhhungtc2020@gmail.com</a></small>
                    </div>

                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-expand-xl navbar-light bg-white">
                    <a href="/shoeimportsystem/index.php?controller=home&action=index" class="navbar-brand">
                        <h1 class="display-6 text-primary"><img src="/shoeimportsystem/views/client/layout/img/logo.jpg" alt="" style="width: 100px;height: 77px;margin-top: 9px;">
                        </h1>
                    </a>
                    <button class="navbar-toggler px-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="text-primary fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="/shoeimportsystem/index.php?controller=home&action=index" class="nav-item nav-link">Trang chủ</a>
                            <a href="/shoeimportsystem/index.php?controller=product&action=index" class="nav-item nav-link">Shop</a>
                            <a href="/shoeimportsystem/index.php?controller=shopdetail&action=index" class="nav-item nav-link">Thông tin shop</a>
                            <div class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">Thương hiệu</a>
                                <div class="dropdown-menu bg-secondary m-0 rounded-0">
                                <?php foreach ($brands as $brand): ?>
                                    <a href="/shoeimportsystem/index.php?controller=brand&action=index&id=<?php echo $brand['MaNCC']; ?>" class="dropdown-item">
                                        <?php echo htmlspecialchars($brand['TenNCC']); ?>
                                    </a>
                                <?php endforeach; ?>

                                </div>
                            </div>
                            <div id="productList">
                                    <!-- Sản phẩm load vào đây -->
                                </div>
                            <a href="/shoeimportsystem/index.php?controller=contact&action=index" class="nav-item nav-link active">Liên hệ</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn btn-md-square btn-search bg-white border border-secondary rounded-circle me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="text-primary fa-search fas"></i></button>

                            <!--  -->
                            <a href="#" class="position-relative me-4 my-auto" id="cart-icon">
                                <i class="fa fa-2x fa-shopping-bag"></i>
                                <span id="cart-count" class="d-flex align-items-center bg-secondary justify-content-center position-absolute rounded-circle text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                    <?php
                                    // Đếm số lượng từ chitietgiohang dựa trên MaGH của người dùng
                                    if (isset($_SESSION['user'])) {
                                        require_once __DIR__ . '/../../../models/client/CartModel.php';
                                        $cartModel = new CartModel();
                                        $cartCount = $cartModel->getCartItemCount($_SESSION['user']['MaKH']);
                                        echo $cartCount;
                                    } else {
                                        echo 0;
                                    }
                                    ?>
                                </span>
                            </a>

                            <!-- Modal chi tiết giỏ hàng -->
                            <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="cart-details">
                                            <!-- Chi tiết giỏ hàng sẽ được tải động bằng AJAX -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            <a href="/shoeimportsystem/index.php?controller=checkout&action=index" class="btn btn-primary">Thanh toán</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="user-menu">
                                <?php if (isset($_SESSION['user'])): ?>
                                    <a href="#" class="my-auto"><i class="fa-2x fa-user fas"></i></a>
                                    <div class="dropdown">
                                        <span>Xin chào, <?php echo htmlspecialchars($_SESSION['user']['TenKH']); ?></span>
                                        <a href="/shoeimportsystem/index.php?controller=auth&action=profile">Thông tin cá nhân</a>
                                        <a href="/shoeimportsystem/index.php?controller=auth&action=logout">Đăng xuất</a>
                                    </div>
                                <?php else: ?>
                                    <a href="/shoeimportsystem/index.php?controller=auth&action=login" class="my-auto"><i class="fa-2x fa-user fas"></i></a>
                                    <div class="dropdown">
                                        <a href="/shoeimportsystem/index.php?controller=auth&action=login">Đăng nhập</a>
                                        <a href="/shoeimportsystem/index.php?controller=auth&action=register">Đăng ký</a>
                                    </div>
                                <?php endif; ?>
                            </div>

                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Hero-Start -->

        <div class="container-fluid hero-header mb-5 py-5">
            <div class="container py-5">
                <div class="g-5 row align-items-center">
                    <div class="col-lg-7 col-md-12">

                        <h1 class="display-3 text-primary mb-5">Web bán giày siêu chất lượng cao</h1>

                        <div>

                        </div>

                    </div>
                    <div class="col-lg-5 col-md-12">
                        <div id="carouselId" class="position-relative carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="rounded active carousel-item">
                                    <img src="/shoeimportsystem/views/client/layout/img/ADIDAS_FORUM_PANDA_3.jpg" class="bg-secondary h-100 rounded w-100 img-fluid" alt="First slide">
                                    <a href="#" class="btn rounded text-white px-4 py-2">ADIDAS</a>
                                </div>
                                <div class="rounded carousel-item">
                                    <img src="/shoeimportsystem/views/client/layout/img/ADIDAS_CAMPUS_00S_GREEN_3.jpg" class="h-100 rounded w-100 img-fluid" alt="Second slide">
                                    <a href="#" class="btn rounded text-white px-4 py-2">SAMBA</a>
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselId" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselId" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hero End -->
        </header>

        <main>
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