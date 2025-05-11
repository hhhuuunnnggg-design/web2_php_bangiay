<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-5">
    <h2>Thanh toán</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Thông tin người nhận</h4>
            <form id="checkout-form">
                <div class="mb-3">
                    <label for="tenNN" class="form-label">Họ tên người nhận</label>
                    <input type="text" class="form-control" id="tenNN" name="tenNN" value="<?php echo htmlspecialchars($userInfo['TenKH'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="diaChiNN" class="form-label">Địa chỉ nhận hàng</label>
                    <input type="text" class="form-control" id="diaChiNN" name="diaChiNN" value="<?php echo htmlspecialchars($userInfo['DiaChi'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sdtNN" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="sdtNN" name="sdtNN" value="<?php echo htmlspecialchars($userInfo['SDT'] ?? ''); ?>" required>
                </div>
                <button type="button" class="btn btn-primary" onclick="confirmCheckout()">Xác nhận thanh toán</button>
            </form>
        </div>
        <div class="col-md-6">
            <h4>Thông tin đơn hàng</h4>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><img src="/shoeimportsystem/public/<?php echo htmlspecialchars($item['Img']); ?>" alt="<?php echo htmlspecialchars($item['TenSanPham']); ?>" style="width: 50px; height: 50px;"></td>
                            <td><?php echo htmlspecialchars($item['TenSanPham']); ?></td>
                            <td><?php echo htmlspecialchars($item['SoLuong']); ?></td>
                            <td><?php echo number_format($item['GiaTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><?php echo number_format($item['TongTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h4>Tổng tiền: <?php echo number_format($cartTotal, 0, ',', '.') . ' VNĐ'; ?></h4>
        </div>
    </div>
</div>

<script>
    function confirmCheckout() {
        const form = document.getElementById('checkout-form');
        const formData = new FormData(form);
        const alertPlaceholder = document.getElementById('liveAlertPlaceholder');

        fetch('/shoeimportsystem/index.php?controller=cart&action=confirmCheckout', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartCountElement = document.querySelector('#cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = '0';
                    }

                    alertPlaceholder.innerHTML = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        Thanh toán thành công!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                    setTimeout(() => {
                        const alert = alertPlaceholder.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => {
                                alert.remove();
                                window.location.href = '/shoeimportsystem/index.php?controller=home&action=index';
                            }, 150);
                        } else {
                            window.location.href = '/shoeimportsystem/index.php?controller=home&action=index';
                        }
                    }, 500);
                } else {
                    alertPlaceholder.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        ${data.message || 'Không thể thanh toán!'}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                    setTimeout(() => {
                        const alert = alertPlaceholder.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                alertPlaceholder.innerHTML = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Có lỗi xảy ra khi thanh toán!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                setTimeout(() => {
                    const alert = alertPlaceholder.querySelector('.alert');
                    if (alert) {
                        alert.classList.remove('show');
                        setTimeout(() => alert.remove(), 150);
                    }
                }, 2000);
            });
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>