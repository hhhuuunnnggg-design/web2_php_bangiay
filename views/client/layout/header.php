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
</head>

<body>
    <header>

        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div class="container topbar bg-primary d-none d-lg-block">
                <div class="d-flex justify-content-between">
                    <div class="top-info ps-2">
                        <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Đại học Sài Gòn</a></small>
                        <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">nguyendinhhungtc2020@gmail.com</a></small>
                    </div>

                </div>
            </div>
            <div class="container px-0">
                <nav class="navbar navbar-light bg-white navbar-expand-xl">
                    <a href="/shoeimportsystem/index.php?controller=home&action=index" class="navbar-brand">
                        <h1 class="text-primary display-6"><img src="/shoeimportsystem/views/client/layout/img/logo.jpg" alt="" style="width: 100px;height: 77px;margin-top: 9px;">
                        </h1>
                    </a>
                    <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars text-primary"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto">
                            <a href="/shoeimportsystem/index.php?controller=home&action=index" class="nav-item nav-link">Home</a>
                            <a href="/shoeimportsystem/index.php?controller=product&action=index" class="nav-item nav-link">Shop</a>
                            <a href="/shoeimportsystem/index.php?controller=product&action=detail" class="nav-item nav-link">Shop Detail</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                    <a href="/shoeimportsystem/index.php?controller=cart&action=index" class="dropdown-item">Cart</a>
                                    <a href="/shoeimportsystem/index.php?controller=checkout&action=index" class="dropdown-item">Checkout</a>
                                    <a href="/shoeimportsystem/index.php?controller=testimonial&action=index" class="dropdown-item">Testimonial</a>
                                    <a href="/shoeimportsystem/index.php?controller=error&action=404" class="dropdown-item">404 Page</a>
                                </div>
                            </div>
                            <a href="/shoeimportsystem/index.php?controller=contact&action=index" class="nav-item nav-link active">Contact</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>
                            <a href="#" class="position-relative me-4 my-auto">
                                <i class="fa fa-shopping-bag fa-2x"></i>
                                <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                            </a>
                            <a href="#" class="my-auto">
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Navbar End -->

        <!-- Hero-Start -->
        <div class="container-fluid py-5 mb-5 hero-header">
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <div class="col-md-12 col-lg-7">

                        <h1 class="mb-5 display-3 text-primary">Web bán giày siêu chất lượng cao</h1>

                        <div>

                        </div>

                    </div>
                    <div class="col-md-12 col-lg-5">
                        <div id="carouselId" class="carousel slide position-relative" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <div class="carousel-item active rounded">
                                    <img src="/shoeimportsystem/views/client/layout/img/ADIDAS_FORUM_PANDA_3.jpg" class="img-fluid w-100 h-100 bg-secondary rounded" alt="First slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">ADIDAS</a>
                                </div>
                                <div class="carousel-item rounded">
                                    <img src="/shoeimportsystem/views/client/layout/img/ADIDAS_CAMPUS_00S_GREEN_3.jpg" class="img-fluid w-100 h-100 rounded" alt="Second slide">
                                    <a href="#" class="btn px-4 py-2 text-white rounded">SAMBA</a>
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
        <div class="container mt-5">
            <h1 class="text-center mb-4">Sản phẩm theo danh mục</h1>
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
                                        <p class="card-text"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (!isset($_GET['category'])): // Chỉ hiển thị "Xem thêm" khi chưa chọn danh mục 
                    ?>
                        <div class="text-center mt-3">
                            <a href="/shoeimportsystem/index.php?controller=home&action=index&category=<?php echo $categoryId; ?>" class="btn btn-primary">Xem thêm</a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>


        </div>