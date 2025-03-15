<h1>Quản lý danh mục</h1>
<div style="display: flex; justify-content: space-between;">
    <form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm danh mục">
        <input type="hidden" name="controller" value="category">
        <input type="hidden" name="action" value="index">
        <button type="submit">Tìm</button>
    </form>
    
    <div>
        <?php if ($auth->checkPermission(1, 'add')): ?>
            <a href="/shoeimportsystem/public/index.php?controller=category&action=add">
                <button type="button" class="btn btn-primary" style="margin-top: 40px; width: 100px; height: 40px;">Thêm</button>
            </a>
            <button type="button" class="btn btn-success" style="margin-top: 40px; width: 100px; height: 40px;" onclick="document.getElementById('importModal').style.display='block'">Import</button>
            <a href="/shoeimportsystem/public/index.php?controller=category&action=export">
                <button type="button" class="btn btn-info" style="margin-top: 40px; width: 100px; height: 40px;">Export</button>
            </a>
        <?php endif; ?>
        
    </div>
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
        require_once __DIR__ . '/../../core/Auth.php'; // Sửa đường dẫn
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
<div class="pagination-container">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-end">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=1">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages - 2): ?>
                <?php if ($page < $totalPages - 3): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $totalPages; ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=category&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- Modal để import -->
<div id="importModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border:1px solid #ccc;">
    <h2>Import danh mục</h2>
    <form id="importForm" enctype="multipart/form-data">
        <label>Chọn file CSV:</label>
        <input type="file" name="importFile" accept=".csv" required><br>
        <button type="submit">Import</button>
        <button type="button" onclick="closeModal()">Hủy</button>
    </form>
</div>

<style>
    .pagination-container { margin-top: 20px; }
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

document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=category&action=import', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Import thành công!</p>';
            closeModal();
            location.reload();
        } else {
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra!</p>';
    });
});

function closeModal() {
    document.getElementById('importModal').style.display = 'none';
}
</script>