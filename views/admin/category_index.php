<h1>Quản lý danh mục</h1>
<div style="
    display: flex;
    justify-content: space-between;">
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm danh mục">
    <input type="hidden" name="controller" value="category">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>
<?php if ($auth->checkPermission(1, 'add')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=category&action=add">
                        <button type="button" class="btn btn-primary" style="
    margin-top: 40px;
    width: 100px;
    height: 40px;
">Thêm</button>
                    </a>
                <?php endif; ?>
</div>

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
        require_once __DIR__ . '../../../core/Auth.php'; // Đường dẫn tới Auth.php
        
        $auth = new Auth();
        if (!empty($categories)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($categories as $row): 
        ?>
        <tr data-id="<?php echo $row['MaDM']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaDM']; ?></td>
            <td><?php echo $row['TenDM']; ?></td>
            <td>
                
                <?php if ($auth->checkPermission(1, 'edit')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=category&action=edit&id=<?php echo $row['MaDM']; ?>">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(1, 'delete')): ?>
                    <a class="delete-btn" data-id="<?php echo $row['MaDM']; ?>">
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </a>
                <?php endif; ?>
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

<!-- Phân trang -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
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