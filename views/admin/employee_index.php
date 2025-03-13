<h1>Quản lý nhân viên</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm nhân viên">
    <input type="hidden" name="controller" value="employee">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="employeeTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Email</th>
            <th>SDT</th>
            <th>Địa chỉ</th>
            <th>Quyền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $auth = new Auth();
        if (!empty($employees)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($employees as $row): 
        ?>
        <tr data-id="<?php echo $row['MaNV']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaNV']; ?></td>
            <td><?php echo $row['TenNV']; ?></td>
            <td><?php echo $row['Email']; ?></td>
            <td><?php echo $row['SDT']; ?></td>
            <td><?php echo $row['DiaChi']; ?></td>
            <td><?php echo $row['TenQuyen']; ?></td>
            <td>
                <?php if ($auth->checkPermission(5, 'add')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=employee&action=add">
                        <button type="button" class="btn btn-primary">Thêm</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(5, 'edit')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=employee&action=edit&id=<?php echo $row['MaNV']; ?>">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(5, 'delete')): ?>
                    <a class="delete-btn" data-id="<?php echo $row['MaNV']; ?>">
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="8">Không có nhân viên nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=employee&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=employee&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=employee&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
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
        if (confirm('Xóa nhân viên này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=employee&action=delete&id=${id}`, {
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