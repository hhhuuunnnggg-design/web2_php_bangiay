<h1>Quản lý quyền</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm quyền">
    <input type="hidden" name="controller" value="role">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="roleTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>ID</th>
            <th>Tên quyền</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (!empty($roles)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($roles as $row): 
        ?>
        <tr data-id="<?php echo $row['id']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['Ten']; ?></td>
            <td><?php echo $row['MoTa']; ?></td>
            <td>
                <?php if ($auth->checkPermission(6, 'add')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=role&action=add">
                        <button type="button" class="btn btn-primary">Thêm</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(6, 'edit')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=role&action=edit&id=<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(6, 'delete')): ?>
                    <a class="delete-btn" data-id="<?php echo $row['id']; ?>">
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="5">Không có quyền nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=role&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=role&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=role&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
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
        if (confirm('Xóa quyền này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=role&action=delete&id=${id}`, {
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