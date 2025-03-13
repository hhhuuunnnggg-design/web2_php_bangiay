<h1>Quản lý nhà cung cấp</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm nhà cung cấp">
    <input type="hidden" name="controller" value="supplier">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="supplierTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã NCC</th>
            <th>Tên NCC</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($suppliers)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($suppliers as $row): 
        ?>
        <tr data-id="<?php echo $row['MaNCC']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaNCC']; ?></td>
            <td><?php echo $row['TenNCC']; ?></td>
            <td>
                <a href="/shoeimportsystem/public/index.php?controller=supplier&action=add">
                    <button type="button" class="btn btn-primary">Thêm</button>
                </a>
                <a href="/shoeimportsystem/public/index.php?controller=supplier&action=edit&id=<?php echo $row['MaNCC']; ?>">
                    <button type="button" class="btn btn-warning">Sửa</button>
                </a>
                <a class="delete-btn" data-id="<?php echo $row['MaNCC']; ?>">
                    <button type="button" class="btn btn-danger">Xóa</button>
                </a>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="4">Không có nhà cung cấp nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
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
        if (confirm('Xóa nhà cung cấp này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=delete&id=${id}`, {
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