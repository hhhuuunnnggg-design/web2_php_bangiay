<h1>Quản lý sản phẩm</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm theo tên">
    <input type="number" name="price_min" value="<?php echo htmlspecialchars($price_min ?? ''); ?>" placeholder="Giá min" min="0">
    <input type="number" name="price_max" value="<?php echo htmlspecialchars($price_max ?? ''); ?>" placeholder="Giá max" min="0">
    <label><input type="checkbox" name="low_stock" value="1" <?php if ($low_stock) echo 'checked'; ?>> Sắp hết (≤ 20)</label>
    <input type="hidden" name="controller" value="product">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="productTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Danh mục</th>
            <th>Nhà cung cấp</th>
            <th>Số lượng</th>
            <th>Mô tả</th>
            <th>Đơn giá</th>
            <th>Ảnh nền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        require_once __DIR__ . '/../../core/Auth.php';
        $auth = new Auth();
        if (!empty($products)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($products as $row): 
        ?>
        <tr data-id="<?php echo $row['MaSP']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaSP']; ?></td>
            <td><?php echo $row['TenSP']; ?></td>
            <td><?php echo $row['TenDM'] ?? ''; ?></td>
            <td><?php echo $row['TenNCC']; ?></td>
            <td><?php echo $row['SoLuong']; ?></td>
            <td><?php echo $row['MoTa'] ?? ''; ?></td>
            <td><?php echo number_format($row['DonGia'], 0, ',', '.'); ?></td>
            <td>
                <?php if (!empty($row['AnhNen'])): ?>
                    <img src="/shoeimportsystem/public/<?php echo $row['AnhNen']; ?>" alt="Ảnh nền" width="50">
                <?php else: ?>
                    Chưa có ảnh
                <?php endif; ?>
            </td>
            <td>
                <?php if ($auth->checkPermission(10, 'add')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=product&action=add">
                        <button type="button" class="btn btn-primary">Thêm</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(10, 'edit')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=product&action=edit&id=<?php echo $row['MaSP']; ?>">
                        <button type="button" class="btn btn-warning">Sửa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(10, 'delete')): ?>
                    <a class="delete-btn" data-id="<?php echo $row['MaSP']; ?>">
                        <button type="button" class="btn btn-danger">Xóa</button>
                    </a>
                <?php endif; ?>
                <?php if ($auth->checkPermission(11, 'view')): ?>
                    <a href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($row['TenSP']); ?>">
                        <button type="button" class="btn btn-info">Nhập hàng</button>
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="10">Không có sản phẩm nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product&action=index&search=<?php echo urlencode($search); ?>&price_min=<?php echo $price_min ?? ''; ?>&price_max=<?php echo $price_max ?? ''; ?>&low_stock=<?php echo $low_stock ? '1' : ''; ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product&action=index&search=<?php echo urlencode($search); ?>&price_min=<?php echo $price_min ?? ''; ?>&price_max=<?php echo $price_max ?? ''; ?>&low_stock=<?php echo $low_stock ? '1' : ''; ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product&action=index&search=<?php echo urlencode($search); ?>&price_min=<?php echo $price_min ?? ''; ?>&price_max=<?php echo $price_max ?? ''; ?>&low_stock=<?php echo $low_stock ? '1' : ''; ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
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