<h1>Quản lý phiếu nhập</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm theo tên sản phẩm">
    <input type="hidden" name="controller" value="import">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="importTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã PN</th>
            <th>Tên NV</th>
            <th>Tên SP</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
            <th>Ngày nhập</th>
            <th>Ghi chú</th>
            <th>Size</th>
            <th>Màu</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        require_once __DIR__ . '/../../core/Auth.php';
        $auth = new Auth();
        if (!empty($imports)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($imports as $row): 
        ?>
        <tr data-id="<?php echo $row['MaPN']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaPN']; ?></td>
            <td><?php echo $row['TenNV']; ?></td>
            <td><?php echo $row['TenSP']; ?></td>
            <td><?php echo $row['SoLuong']; ?></td>
            <td><?php echo number_format($row['DonGia'], 0, ',', '.'); ?></td>
            <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?></td>
            <td><?php echo $row['NgayNhap']; ?></td>
            <td><?php echo $row['Note'] ?? ''; ?></td>
            <td><?php echo $row['Size']; ?></td>
            <td><?php echo $row['Mau']; ?></td>
            <td>
                <?php if ($auth->checkPermission(11, 'edit')): ?> <!-- Đổi thành 11 -->
                    <a href="/shoeimportsystem/public/index.php?controller=import&action=edit&id=<?php echo $row['MaPN']; ?>">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(11, 'delete')): ?> <!-- Đổi thành 11 -->
                    <a class="delete-btn" data-id="<?php echo $row['MaPN']; ?>">
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="12">Không có phiếu nhập nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
    <?php endif; ?>
</div>

<style>
    .pagination { margin-top: 20px; }
    .pagination a { margin: 0 5px; text-decoration: none; }
    .pagination a:hover { text-decoration: underline; }
</style>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        if (confirm('Xóa phiếu nhập này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=import&action=delete&id=${id}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`tr[data-id="${id}"]`).remove();
                    document.getElementById('message').innerHTML = '<p style="color:green;">Xóa thành công!</p>';
                } else {
                    document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + data.message + '</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra!</p>';
            });
        }
    });
});
</script>