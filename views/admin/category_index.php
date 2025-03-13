<h1>Quản lý danh mục</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm danh mục">
    <input type="hidden" name="controller" value="category">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="categoryTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã DM</th>
            <th>Tên DM</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($categories)): 
            $stt = 1;
            foreach ($categories as $row): 
        ?>
        <tr data-id="<?php echo $row['MaDM']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaDM']; ?></td>
            <td><?php echo $row['TenDM']; ?></td>
            <td>
                <a href="/shoeimportsystem/public/index.php?controller=category&action=add">
                    <button type="button" class="btn btn-primary">Thêm</button>
                </a>
                <a href="/shoeimportsystem/public/index.php?controller=category&action=edit&id=<?php echo $row['MaDM']; ?>">
                    <button type="button" class="btn btn-warning">Sửa</button>
                </a>
                <a class="delete-btn" data-id="<?php echo $row['MaDM']; ?>">
                    <button type="button" class="btn btn-danger">Xóa</button>
                </a>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="4">Không có danh mục nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        if (confirm('Xóa danh mục này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=category&action=delete&id=${id}`, {
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