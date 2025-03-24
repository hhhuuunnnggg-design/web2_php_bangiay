<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-5">
    <h2 style="margin-right: 20px;">Giỏ hàng của bạn</h2>
    <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=index" class="position-relative me-4 my-auto" id="order-history-icon">Lịch sử mua hàng </a></h2>
    <!-- end gio hang -->

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
                    <tr>
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
        if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            fetch('/shoeimportsystem/index.php?controller=cart&action=removeFromCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `maGH=${maGH}&maSP=${maSP}&size=${size}&maMau=${encodeURIComponent(maMau)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Đã xóa sản phẩm khỏi giỏ hàng!');
                        document.querySelector('#cart-count').textContent = data.cartCount;
                        location.reload();
                    } else {
                        alert(data.message || 'Không thể xóa sản phẩm!');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    alert('Có lỗi xảy ra khi xóa sản phẩm!');
                });
        }
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>