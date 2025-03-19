<h1>Thống kê</h1>
<div id="message"></div>

<div style="margin-bottom: 40px;">
    <h2>Doanh thu theo tháng</h2>
    <table border="1" style="width: 50%;">
        <thead>
            <tr>
                <th>Tháng</th>
                <th>Doanh thu (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($revenueStats)): ?>
                <?php foreach ($revenueStats as $row): ?>
                    <tr>
                        <td><?php echo $row['Thang']; ?></td>
                        <td><?php echo number_format($row['DoanhThu'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">Không có dữ liệu doanh thu.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-bottom: 40px;">
    <h2>Top 10 sản phẩm bán chạy</h2>
    <table border="1" style="width: 50%;">
        <thead>
            <tr>
                <th>Mã SP</th>
                <th>Tên SP</th>
                <th>Số lượng bán</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($topProducts)): ?>
                <?php foreach ($topProducts as $row): ?>
                    <tr>
                        <td><?php echo $row['MaSP']; ?></td>
                        <td><?php echo $row['TenSP']; ?></td>
                        <td><?php echo $row['SoLuongBan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có dữ liệu sản phẩm.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-bottom: 40px;">
    <h2>Hoạt động nhân viên (Top 10)</h2>
    <table border="1" style="width: 50%;">
        <thead>
            <tr>
                <th>Mã NV</th>
                <th>Tên NV</th>
                <th>Số hóa đơn xử lý</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($employeeStats)): ?>
                <?php foreach ($employeeStats as $row): ?>
                    <tr>
                        <td><?php echo $row['MaNV']; ?></td>
                        <td><?php echo $row['TenNV']; ?></td>
                        <td><?php echo $row['SoHoaDon']; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có dữ liệu nhân viên.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<style>
    table {
        margin-top: 20px;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>