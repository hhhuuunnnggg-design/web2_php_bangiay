<h1>Quản lý chi tiết sản phẩm</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search_name" value="<?php echo htmlspecialchars($search_name ?? ''); ?>" placeholder="Tìm kiếm theo tên sản phẩm">
    <input type="text" name="search_color" value="<?php echo htmlspecialchars($search_color ?? ''); ?>" placeholder="Tìm kiếm theo mã màu">
    <input type="text" name="search_size" value="<?php echo htmlspecialchars($search_size ?? ''); ?>" placeholder="Tìm kiếm theo size">
    <input type="hidden" name="controller" value="product_detail">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="productDetailTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Mã Size</th>
            <th>Mã Màu</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        require_once __DIR__ . '/../../core/Auth.php';
        $auth = new Auth();
        if (!empty($productDetails)): 
            $stt = ($page - 1) * $limit + 1;
            foreach ($productDetails as $row): 
        ?>
        <tr data-masp="<?php echo $row['MaSP']; ?>" data-size="<?php echo $row['MaSize']; ?>" data-mau="<?php echo $row['MaMau']; ?>">
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaSP']; ?></td>
            <td><?php echo $row['TenSP']; ?></td>
            <td><?php echo $row['MaSize']; ?></td>
            <td><?php echo $row['MaMau']; ?></td>
            <td><?php echo $row['SoLuong']; ?></td>
            <td>
                <?php if ($auth->checkPermission(11, 'add')): ?> <!-- Đổi thành 11 -->
                    <button type="button" class="btn btn-success import-btn" 
                            data-masp="<?php echo $row['MaSP']; ?>" 
                            data-size="<?php echo $row['MaSize']; ?>" 
                            data-mau="<?php echo $row['MaMau']; ?>" 
                            data-tensp="<?php echo htmlspecialchars($row['TenSP']); ?>">
                        Nhập kho
                    </button>
                <?php endif; ?>
            </td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="7">Không có chi tiết sản phẩm nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
    <?php endif; ?>
</div>

<div id="importModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border:1px solid #ccc;">
    <h2>Nhập kho</h2>
    <form id="importForm">
        <input type="hidden" name="MaSP" id="importMaSP">
        <input type="hidden" name="Size" id="importSize">
        <input type="hidden" name="Mau" id="importMau">
        <label>Tên sản phẩm:</label>
        <input type="text" id="importTenSP" disabled><br>
        <label>Số lượng nhập:</label>
        <input type="number" name="SoLuong" min="1" required><br>
        <label>Đơn giá (VNĐ):</label>
        <input type="number" name="DonGia" min="0" required><br>
        <label>Ghi chú:</label>
        <textarea name="Note"></textarea><br>
        <button type="submit">Xác nhận nhập kho</button>
        <button type="button" onclick="closeModal()">Hủy</button>
    </form>
</div>

<style>
    .pagination { margin-top: 20px; }
    .pagination a { margin: 0 5px; text-decoration: none; }
    .pagination a:hover { text-decoration: underline; }
</style>

<script>
document.querySelectorAll('.import-btn').forEach(button => {
    button.addEventListener('click', function() {
        const maSP = this.getAttribute('data-masp');
        const size = this.getAttribute('data-size');
        const mau = this.getAttribute('data-mau');
        const tenSP = this.getAttribute('data-tensp');

        document.getElementById('importMaSP').value = maSP;
        document.getElementById('importSize').value = size;
        document.getElementById('importMau').value = mau;
        document.getElementById('importTenSP').value = tenSP;
        document.getElementById('importModal').style.display = 'block';
    });
});

document.getElementById('importForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=import&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Nhập kho thành công!</p>';
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