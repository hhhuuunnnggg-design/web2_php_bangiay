<?php include __DIR__ . '/../layout/header.php'; ?>

<div class="container mt-5">
    <h1>Lịch sử mua hàng của bạn</h1>
    <?php if (!empty($orders)): ?>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Mã hóa đơn</th>
                    <th>Ngày đặt</th>
                    <th>Người nhận</th>
                    <th>Địa chỉ</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Tình trạng</th>
                    <th>Hành động</th> <!-- Thay "Sản phẩm" bằng "Hành động" -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['MaHD']; ?></td>
                        <td><?php echo $order['NgayDat']; ?></td>
                        <td><?php echo htmlspecialchars($order['TenNN'] ?? 'Chưa có'); ?></td>
                        <td><?php echo htmlspecialchars($order['DiaChiNN'] ?? 'Chưa có'); ?></td>
                        <td><?php echo $order['SDTNN'] ?? 'Chưa có'; ?></td>
                        <td><?php echo number_format($order['TongTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                        <td><?php echo $order['TinhTrang']; ?></td>
                        <td>
                            <a href="/shoeimportsystem/index.php?controller=orderhistory&action=detail&id=<?php echo $order['MaHD']; ?>" class="btn btn-info btn-sm">Xem chi tiết</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    <?php endif; ?>
    <a href="/shoeimportsystem/index.php?controller=home&action=index" class="btn btn-secondary mt-3">Quay lại trang chủ</a>
</div>

<?php include __DIR__ . '/../layout/footer.php'; ?>