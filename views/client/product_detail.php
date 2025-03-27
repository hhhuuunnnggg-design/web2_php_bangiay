<?php
include __DIR__ . '/layout/header.php';
?>

<div class="container mt-5">
    <div class="breadcrumb">

        <a href="/shoeimportsystem/index.php?controller=home&action=index">Trang chủ</a> » Chi tiết sản phẩm
    </div>
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($product['AnhNen'] ?? 'images/default-product.jpg'); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
        </div>
        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($product['TenSP']); ?></h1>
            <p class="fs-3">
                <?php if ($product['GiaKhuyenMai'] < $product['DonGia']): ?>
                    <span class="text-danger font-weight-bold"><?php echo number_format($product['GiaKhuyenMai'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                    <span style="text-decoration: line-through; color: gray;"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                <?php else: ?>
                    <span class="text-danger"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                <?php endif; ?>
            </p>
            <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['TenDM']); ?></p>
            <p><strong>Nhà cung cấp:</strong> <?php echo htmlspecialchars($product['TenNCC']); ?></p>

            <!-- Kích thước -->
            <div class="mb-3">
                <label><strong>Kích thước:</strong></label><br>
                <?php
                $sizes = array_unique(array_column($productDetails, 'MaSize'));
                foreach ($sizes as $size):
                    if ($size):
                ?>
                        <input type="radio" name="size" value="<?php echo $size; ?>" id="size-<?php echo $size; ?>">
                        <label for="size-<?php echo $size; ?>"><?php echo $size; ?></label>
                <?php endif;
                endforeach; ?>
            </div>

            <!-- Màu sắc -->
            <div class="mb-3">
                <label><strong>Màu sắc:</strong></label><br>
                <?php
                $colors = array_unique(array_column($productDetails, 'MaMau'));
                foreach ($colors as $color):
                    if ($color):
                ?>
                        <input type="radio" name="color" value="<?php echo $color; ?>" id="color-<?php echo $color; ?>">
                        <label for="color-<?php echo $color; ?>"><?php echo $color; ?></label>
                <?php endif;
                endforeach; ?>
            </div>

            <!-- Số lượng -->
            <div class="mb-3">
                <label><strong>Số lượng:</strong></label>
                <div class="input-group w-25">
                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()" style="width: 0px;">-</button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1">
                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()" style="width: 0px;">+</button>
                </div>
            </div>

            <!-- Nút thêm giỏ hàng và mua ngay -->
            <div class="mb-3">
                <button class="btn btn-primary me-2" onclick="addToCart(<?php echo $product['MaSP']; ?>)">Thêm vào giỏ hàng</button>
                <button class="btn btn-success" onclick="buyNow(<?php echo $product['MaSP']; ?>)">Mua ngay</button>
            </div>
        </div>
    </div>
</div>

<div class="product-details">
    <div class="description-reviews">
        <div class="tabs">
            <button class="active tab-button" data-tab="description">MÔ TẢ</button>
            <button class="tab-button" data-tab="reviews">ĐÁNH GIÁ</button>
        </div>

        <div class="tab-content" id="description">
            <p><?php echo htmlspecialchars($product['MoTa']); ?></p>
        </div>
        <div class="hidden tab-content" id="reviews">
            <form id="review-form" method="post">
                <textarea name="comment" placeholder="Viết đánh giá..."></textarea><br>
                <button type="button" id="submit-review" class="review-button">Đánh giá</button>
            </form>
            <?php if (!empty($reviews)): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($review['TenKH']); ?></p>
                        <p><strong>Thời gian:</strong> <?php echo htmlspecialchars($review['ThoiGian']); ?></p>
                        <p><?php echo htmlspecialchars($review['NoiDung']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-reviews">CHƯA CÓ ĐÁNH GIÁ NÀO</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<script>
    function increaseQuantity() {
        let quantity = document.getElementById('quantity');
        quantity.value = parseInt(quantity.value) + 1;
    }

    function decreaseQuantity() {
        let quantity = document.getElementById('quantity');
        if (parseInt(quantity.value) > 1) {
            quantity.value = parseInt(quantity.value) - 1;
        }
    }

    function addToCart(productId) {
        let size = document.querySelector('input[name="size"]:checked')?.value;
        let color = document.querySelector('input[name="color"]:checked')?.value;
        let quantity = document.getElementById('quantity').value;

        const alertPlaceholder = document.getElementById('liveAlertPlaceholder');

        if (!size || !color) {
            alertPlaceholder.innerHTML = `
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                Vui lòng chọn kích thước và màu sắc!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
            setTimeout(() => {
                const alert = alertPlaceholder.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150); // Xóa sau khi animation hoàn tất
                }
            }, 2000); // Biến mất sau 1 giây
            return;
        }

        console.log(`Sending: productId=${productId}, quantity=${quantity}, size=${size}, color=${color}`);

        fetch('/shoeimportsystem/index.php?controller=cart&action=addToCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `productId=${productId}&quantity=${quantity}&size=${size}&color=${color}`
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.log('Raw response:', text);
                        throw new Error(`Server error: ${response.status} - ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Parsed JSON:', data);
                if (data.success) {
                    alertPlaceholder.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        Đã thêm vào giỏ hàng!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                    const cartCountElement = document.querySelector('#cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = data.cartCount;
                    }
                } else {
                    alertPlaceholder.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${data.message || 'Không thể thêm vào giỏ hàng!!!'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                }
                // Thêm setTimeout để tự động tắt thông báo sau 1 giây
                setTimeout(() => {
                    const alert = alertPlaceholder.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150); // Xóa sau khi animation hoàn tất
                    }
                }, 2000); // Biến mất sau 1 giây
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alertPlaceholder.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Có lỗi xảy ra khi thêm vào giỏ hàng: ${error.message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                setTimeout(() => {
                    const alert = alertPlaceholder.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150); // Xóa sau khi animation hoàn tất
                    }
                }, 2000); // Biến mất sau 1 giây
            });
    }

    function buyNow(productId) {
        let size = document.querySelector('input[name="size"]:checked')?.value;
        let color = document.querySelector('input[name="color"]:checked')?.value;
        let quantity = document.getElementById('quantity').value;
        if (!size || !color) {
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng chọn kích thước và màu sắc!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            return;
        }
        <?php if (!isset($_SESSION['user'])): ?>
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng đăng nhập để mua hàng!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            window.location.href = '/shoeimportsystem/index.php?controller=auth&action=login';
        <?php else: ?>
            window.location.href = `/shoeimportsystem/index.php?controller=checkout&action=index&product=${productId}&size=${size}&color=${color}&quantity=${quantity}`;
        <?php endif; ?>
    }
    // Thêm JavaScript để xử lý các tab như trong ví dụ trước
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.dataset.tab;

            // Ẩn tất cả nội dung tab
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });

            // Hiển thị nội dung tab được chọn
            document.getElementById(tab).classList.remove('hidden');

            // Đánh dấu nút tab được chọn là active
            tabButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        });
    });


    document.getElementById('submit-review').addEventListener('click', function() {
        <?php if (!isset($_SESSION['user'])): ?>
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng đăng nhập để gửi đánh giá!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            window.location.href = '/shoeimportsystem/index.php?controller=auth&action=login';
            return;
        <?php endif; ?>
        const form = document.getElementById('review-form');
        const comment = form.comment.value.trim();
        const productId = <?php echo $product['MaSP']; ?>;

        if (!comment) {
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng nhập nội dung đánh giá!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            return;
        }

        fetch('/shoeimportsystem/index.php?controller=comment&action=addComment&productId=' + productId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'comment=' + encodeURIComponent(comment),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Server trả về lỗi: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('liveAlertPlaceholder').innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        Đánh giá thành công!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                    setTimeout(() => {
                        const alert = document.querySelector('#liveAlertPlaceholder .alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }, 2000);
                    const reviewDiv = document.createElement('div');
                    reviewDiv.classList.add('review');
                    reviewDiv.innerHTML = `<p><strong>Khách hàng:</strong> <?php echo $_SESSION['user']['MaKH']; ?></p><p><strong>Thời gian:</strong> ${data.ThoiGian}</p><p>${comment}</p>`;
                    document.querySelector('#reviews').appendChild(reviewDiv);
                    form.comment.value = '';
                } else {

                    document.getElementById('liveAlertPlaceholder').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${data.message || 'Có lỗi xảy ra khi thêm đánh giá.'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    setTimeout(() => {
                        const alert = document.querySelector('#liveAlertPlaceholder .alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Lỗi chi tiết:', error);

                document.getElementById('liveAlertPlaceholder').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${error.message || 'ó lỗi xảy ra khi gửi đánh giá:'}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
            });
    });

    function buyNow(productId) {
        let size = document.querySelector('input[name="size"]:checked')?.value;
        let color = document.querySelector('input[name="color"]:checked')?.value;
        let quantity = document.getElementById('quantity').value;

        if (!size || !color) {
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng chọn kích thước và màu sắc!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            return;
        }
        <?php if (!isset($_SESSION['user'])): ?>
            document.getElementById('liveAlertPlaceholder').innerHTML = `
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Warning:"><use xlink:href="#exclamation-triangle-fill"/></svg>
            Vui lòng đăng nhập để mua hàng!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
            setTimeout(() => {
                const alert = document.querySelector('#liveAlertPlaceholder .alert');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 2000);
            window.location.href = '/shoeimportsystem/index.php?controller=auth&action=login';
        <?php else: ?>
            fetch('/shoeimportsystem/index.php?controller=cart&action=addToCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `productId=${productId}&quantity=${quantity}&size=${size}&color=${color}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector('#cart-count').textContent = data.cartCount;
                        window.location.href = '/shoeimportsystem/index.php?controller=cart&action=checkout';
                    } else {
                        document.getElementById('liveAlertPlaceholder').innerHTML = `
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                ${data.message || 'Không thể thêm vào giỏ hàng để mua ngay!'}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `;
                        setTimeout(() => {
                            const alert = document.querySelector('#liveAlertPlaceholder .alert');
                            if (alert) {
                                alert.classList.remove('show');
                                setTimeout(() => alert.remove(), 150);
                            }
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    document.getElementById('liveAlertPlaceholder').innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Có lỗi xảy ra khi mua ngay!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    setTimeout(() => {
                        const alert = document.querySelector('#liveAlertPlaceholder .alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }, 2000);
                });
        <?php endif; ?>
    }
    // 
</script>

<style>
    .review {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        position: relative;
    }

    .review p {
        margin: 5px 0;
        font-size: 16px;
    }

    .review strong {
        color: #333;
    }

    .review .review-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .review .review-header i {
        color: #ffcc00;
        /* Màu vàng cho icon */
        font-size: 20px;
    }

    .review .stars {
        color: #ffcc00;
        font-size: 18px;
    }
</style>

<?php
include __DIR__ . '/layout/footer.php';
?>