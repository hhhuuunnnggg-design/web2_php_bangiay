<h1>Chi tiết hóa đơn - <?php echo $order['MaHD']; ?></h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=order&action=index">
            Quản lý hóa đơn
        </a>
    </li>
</ul>

<div>
    <p><strong>Mã hóa đơn:</strong> <?php echo $order['MaHD']; ?></p>
    <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenKH']); ?></p>
    <p><strong>Nhân viên:</strong> <?php echo htmlspecialchars($order['TenNV'] ?? 'Chưa phân công'); ?></p>
    <p><strong>Ngày đặt:</strong> <?php echo $order['NgayDat']; ?></p>
    <p><strong>Ngày giao:</strong> <?php echo $order['NgayGiao'] ?? 'Chưa giao'; ?></p>
    <p><strong>Tình trạng:</strong> <?php echo $order['TinhTrang']; ?></p>
    <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TongTien'], 0, ',', '.') . ' VNĐ'; ?></p>
</div>

<h2>Chi tiết sản phẩm</h2>
<table border="1">
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
            <th>Kích thước</th>
            <th>Màu sắc</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($orderDetails)): ?>
            <?php $stt = 1;
            foreach ($orderDetails as $detail): ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo htmlspecialchars($detail['TenSP']); ?></td>
                    <td><?php echo $detail['SoLuong']; ?></td>
                    <td><?php echo number_format($detail['DonGia'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo number_format($detail['ThanhTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td><?php echo $detail['Size']; ?></td>
                    <td><?php echo $detail['MaMau']; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Không có sản phẩm nào trong hóa đơn.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>