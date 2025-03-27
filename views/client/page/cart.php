<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-5">
    <h2 style="margin-right: 20px;">Giỏ hàng của bạn</h2>
    <div style="display: flex; gap: 20px;">
        <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=index" class="position-relative me-4 my-auto" id="order-history-icon">Lịch sử mua hàng</a></h2>
        <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=canceled" class="position-relative me-4 my-auto" id="canceled-orders-icon">Đơn hàng đã hủy</a></h2>
        <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=shipping" class="position-relative me-4 my-auto" id="shipping-orders-icon">Đơn đang vận chuyển</a></h2>
    </div>

    <?php if (!empty($cartItems)): ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Tổng tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr data-ma-gh="<?php echo htmlspecialchars($item['MaGH']); ?>"
                        data-ma-sp="<?php echo htmlspecialchars($item['MaSP']); ?>"
                        data-size="<?php echo htmlspecialchars($item['Size']); ?>"
                        data-ma-mau="<?php echo htmlspecialchars($item['MaMau']); ?>">
                        <td><img src="/shoeimportsystem/public/<?php echo htmlspecialchars($item['Img']); ?>" alt="<?php echo htmlspecialchars($item['TenSanPham']); ?>" style="width: 50px; height: 50px;"></td>
                        <td><?php echo htmlspecialchars($item['TenSanPham']); ?></td>
                        <td><?php echo htmlspecialchars($item['Size']); ?></td>
                        <td><?php echo htmlspecialchars($item['MaMau']); ?></td>
                        <td><?php echo number_format($item['GiaTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo htmlspecialchars($item['SoLuong']); ?></td>
                        <td><?php echo number_format($item['TongTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeFromCart(<?php echo $item['MaGH']; ?>, <?php echo $item['MaSP']; ?>, <?php echo $item['Size']; ?>, '<?php echo $item['MaMau']; ?>')">Xóa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-right">
            <h4>Tổng tiền: <?php echo number_format($cartTotal, 0, ',', '.') . ' VNĐ'; ?></h4>
            <a href="/shoeimportsystem/index.php?controller=cart&action=checkout" class="btn btn-success">Thanh toán</a>
        </div>
    <?php else: ?>
        <p class="text-center">Giỏ hàng của bạn hiện đang trống.</p>
    <?php endif; ?>
</div>

<script>
    function removeFromCart(maGH, maSP, size, maMau) {

        fetch('/shoeimportsystem/index.php?controller=cart&action=removeFromCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `maGH=${maGH}&maSP=${maSP}&size=${size}&maMau=${encodeURIComponent(maMau)}`
            })
            .then(response => response.json())
            .then(data => {
                const alertPlaceholder = document.getElementById('liveAlertPlaceholder');
                if (data.success) {
                    alertPlaceholder.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                            Đã xóa sản phẩm khỏi giỏ hàng!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    // Cập nhật số lượng giỏ hàng
                    document.querySelector('#cart-count').textContent = data.cartCount;

                    // Xóa hàng tương ứng khỏi bảng mà không reload
                    const rowToRemove = document.querySelector(`tr[data-ma-gh="${maGH}"][data-ma-sp="${maSP}"][data-size="${size}"][data-ma-mau="${maMau}"]`);
                    if (rowToRemove) {
                        rowToRemove.remove();
                    }

                    // Cập nhật tổng tiền (nếu còn sản phẩm)
                    const rows = document.querySelectorAll('tbody tr');
                    if (rows.length === 0) {
                        document.querySelector('.table').remove();
                        document.querySelector('.text-right').remove();
                        document.querySelector('.container.mt-5').innerHTML += '<p class="text-center">Giỏ hàng của bạn hiện đang trống.</p>';
                    } else {
                        // Tính lại tổng tiền từ các hàng còn lại
                        let newTotal = 0;
                        rows.forEach(row => {
                            const totalCell = row.querySelector('td:nth-child(7)').textContent;
                            const totalValue = parseFloat(totalCell.replace(/[^\d]/g, ''));
                            newTotal += totalValue;
                        });
                        document.querySelector('.text-right h4').textContent = `Tổng tiền: ${newTotal.toLocaleString('vi-VN')} VNĐ`;
                    }

                    // Tự động ẩn thông báo sau 2 giây
                    setTimeout(() => {
                        const alert = alertPlaceholder.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            setTimeout(() => alert.remove(), 150);
                        }
                    }, 2000);
                } else {
                    alertPlaceholder.innerHTML = `
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            ${data.message || 'Không thể xóa sản phẩm!'}
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
                document.getElementById('liveAlertPlaceholder').innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Có lỗi xảy ra khi xóa sản phẩm!
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

    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>