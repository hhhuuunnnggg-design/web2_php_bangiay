<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

    <style>
        #searchResults {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 80vh;
            overflow-y: auto;
        }

        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }

        .loading.active {
            display: block;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #searchResults .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(207px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        #searchResults .card {
            transition: transform 0.2s;
        }

        #searchResults .card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <head>
        <!-- Navbar start -->
        <div class="container-fluid fixed-top">
            <div id="liveAlertPlaceholder"></div>

            <!-- SVG icons -->
            <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                <symbol id="check-circle-fill" viewBox="0 0 16 16">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </symbol>
                <symbol id="info-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                </symbol>
                <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                </symbol>
            </svg>

            <!-- Topbar -->
            <div class="container d-lg-block d-none bg-primary topbar">
                <div class="d-flex justify-content-between">
                    <div class="ps-2 top-info">
                        <small class="me-3"><i class="text-secondary fa-map-marker-alt fas me-2"></i> <a href="#" class="text-white">Đại học Sài Gòn</a></small>
                        <small class="me-3"><i class="text-secondary fa-envelope fas me-2"></i><a href="#" class="text-white">nguyendinhhungtc2020@gmail.com</a></small>
                    </div>
                </div>
            </div>

            <!-- Navbar -->
            <div class="container px-0">
                <nav class="navbar navbar-expand-xl navbar-light bg-white">
                    <a href="/shoeimportsystem/index.php?controller=home&action=index" class="navbar-brand">
                        <h1 class="display-6 text-primary"><img src="/shoeimportsystem/views/client/layout/img/logo.jpg" alt="" style="width: 100px;height: 77px;margin-top: 9px;"></h1>
                    </a>
                    <button class="navbar-toggler px-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="text-primary fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                        <div class="navbar-nav mx-auto " style="display: flex; flex-wrap: nowrap;">
                            <a href="/shoeimportsystem/index.php?controller=home&action=index" class="nav-item nav-link" style="white-space: nowrap;">Trang chủ</a>
                            <a href="/shoeimportsystem/index.php?controller=shop&action=index" class="nav-item nav-link">Shop</a>
                            <a href="/shoeimportsystem/index.php?controller=shopdetail&action=index" class="nav-item nav-link" style="white-space: nowrap;">Thông tin shop</a>
                            <div class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown" style="white-space: nowrap;">Thương hiệu</a>
                                <div class="dropdown-menu bg-secondary m-0 rounded-0">
                                    <?php foreach ($brands as $brandItem): ?> <!-- Đổi $brand thành $brandItem -->
                                        <a href="/shoeimportsystem/index.php?controller=brand&action=index&id=<?php echo $brandItem['MaNCC']; ?>" class="dropdown-item">
                                            <?php echo htmlspecialchars($brandItem['TenNCC']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <a href="/shoeimportsystem/index.php?controller=contact&action=index" class="nav-item nav-link active" style="white-space: nowrap;">Liên hệ</a>
                        </div>
                        <div class="d-flex m-3 me-0">
                            <button class="btn btn-md-square btn-search bg-white border border-secondary rounded-circle me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="text-primary fa-search fas"></i></button>
                            <a href="/shoeimportsystem/index.php?controller=cart&action=index" class="position-relative me-4 my-auto" id="cart-icon">
                                <a href="/shoeimportsystem/index.php?controller=cart&action=index" class="position-relative me-4 my-auto" id="cart-icon" style="margin-left:440px;">
                                    <i class="fa fa-2x fa-shopping-bag"></i>
                                    <span id="cart-count" class="d-flex align-items-center bg-secondary justify-content-center position-absolute rounded-circle text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                        <?php
                                        if (isset($_SESSION['user'])) {
                                            echo $_SESSION['cart_count'] ?? 0;
                                        } else {
                                            echo 0;
                                        }
                                        ?>
                                    </span>
                                </a>
                                <!-- User menu -->
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

        <!-- Search Modal -->
        <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="searchModalLabel">Tìm kiếm sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="searchForm" method="GET" action="/shoeimportsystem/index.php">
                            <input type="hidden" name="controller" value="home">
                            <input type="hidden" name="action" value="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="term" id="searchInput" placeholder="Nhập tên sản phẩm..." required>
                                <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                            </div>
                        </form>
                        <div id="searchResults" class="mt-3" style="display: none;">
                            <div class="loading">
                                <div class="loading-spinner"></div>
                                <p>Đang tìm kiếm...</p>
                            </div>
                            <div class="product-grid"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </head>
    <?php include __DIR__ . '/../page/main.php'; ?>

    <!-- Add this before closing body tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            const searchInput = document.getElementById('searchInput');
            const searchResults = document.getElementById('searchResults');
            const productGrid = searchResults.querySelector('.product-grid');
            const loading = searchResults.querySelector('.loading');
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();

                if (searchTerm.length > 0) {
                    searchResults.style.display = 'block';
                    loading.classList.add('active');
                    productGrid.innerHTML = '';

                    searchTimeout = setTimeout(() => {
                        fetch(`/shoeimportsystem/index.php?controller=home&action=search&term=${encodeURIComponent(searchTerm)}`, {
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest'
                                }
                            })
                            .then(response => response.text())
                            .then(html => {
                                loading.classList.remove('active');
                                productGrid.innerHTML = html;
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                loading.classList.remove('active');
                                productGrid.innerHTML = '<p class="text-center text-danger">Có lỗi xảy ra khi tìm kiếm. Vui lòng thử lại.</p>';
                            });
                    }, 300); // Debounce for 300ms
                } else {
                    searchResults.style.display = 'none';
                }
            });

            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const searchTerm = searchInput.value.trim();
                if (searchTerm) {
                    window.location.href = `/shoeimportsystem/index.php?controller=home&action=search&term=${encodeURIComponent(searchTerm)}`;
                }
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchResults.contains(e.target) && e.target !== searchInput) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>