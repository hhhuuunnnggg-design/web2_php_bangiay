<h1>Quản lý sản phẩm</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm sản phẩm">
    <input type="hidden" name="controller" value="product">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="productTable">
    <thead>
        <tr>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Mô tả</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Màu sắc</th>
            <th>Kích thước</th>
            <th>Nhà cung cấp</th>
            <th>Ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $row): ?>
            <tr data-id="<?php echo $row['masanpham']; ?>">
                <td><?php echo $row['masanpham']; ?></td>
                <td><?php echo $row['tensanpham']; ?></td>
                <td><?php echo $row['mota'] ?? ''; ?></td>
                <td><?php echo number_format($row['giaban'], 2); ?></td>
                <td><?php echo $row['soluongconlai']; ?></td>
                <td><?php echo $row['tenmau'] ?? ''; ?></td>
                <td><?php echo $row['tensize'] ?? ''; ?></td>
                <td><?php echo $row['nhacungcap'] ?? ''; ?></td>
                <td>
                    <?php if (!empty($row['anh'])): ?>
                        <img src="/shoeimportsystem/public/<?php echo $row['anh']; ?>" alt="Ảnh sản phẩm" width="50">
                    <?php else: ?>
                        Chưa có ảnh
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/shoeimportsystem/public/index.php?controller=product&action=edit&id=<?php echo $row['masanpham']; ?>">Sửa</a>
                    <button class="delete-btn" data-id="<?php echo $row['masanpham']; ?>">Xóa</button>
                    <a href="/shoeimportsystem/public/index.php?controller=product&action=add">Thêm</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">Không có sản phẩm nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
// Xóa sản phẩm bằng AJAX
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        if (confirm('Xóa sản phẩm này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=product&action=delete&id=${id}`, {
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