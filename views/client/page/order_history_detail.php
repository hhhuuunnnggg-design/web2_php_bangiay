<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">

    <div class="mb-4">

        <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TongTien'], 0, ',', '.') . ' VNĐ'; ?></p>

    </div>


    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Kích thước</th>
                <th>Màu sắc</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>

            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orderDetails)): ?>
                <?php foreach ($orderDetails as $detail): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detail['TenSP']); ?></td>
                        <td>
                            <?php if (!empty($detail['img'])): ?>
                                <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($detail['img']); ?>" alt="<?php echo htmlspecialchars($detail['TenSP']); ?>" style="max-width: 100px; height: auto;">
                            <?php else: ?>
                                Không có ảnh
                            <?php endif; ?>
                        </td>
                        <td><?php echo $detail['Size']; ?></td>
                        <td><?php echo $detail['MaMau']; ?></td>
                        <td><?php echo $detail['SoLuong']; ?></td>
                        <td><?php echo number_format($detail['DonGia'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo number_format($detail['ThanhTien'], 0, ',', '.') . ' VNĐ'; ?></td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Không có sản phẩm nào trong hóa đơn.</td> <!-- Cập nhật colspan thành 7 -->
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <a href="/shoeimportsystem/index.php?controller=orderhistory&action=index" class="btn btn-secondary mt-3">Quay lại</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>