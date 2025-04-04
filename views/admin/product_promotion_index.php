<h1>Quản lý sản phẩm khuyến mãi</h1>
<div style="display: flex;justify-content: space-between;">

    <form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm theo tên sản phẩm hoặc khuyến mãi">
        <input type="hidden" name="controller" value="product_promotion">
        <input type="hidden" name="action" value="index">
        <button type="submit">Tìm</button>
    </form>
    <?php if ($auth->checkPermission(9, 'add')): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=add">
            <button type="button" class="btn btn-primary" style="margin-top: 40px; width: 100px; height: 40px;">Thêm</button>
        </a>
    <?php endif; ?>
</div>

<div id="message"></div>

<table border="1" id="productPromotionTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Mã KM</th>
            <th>Tên Khuyen Mai</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once __DIR__ . '/../../core/Auth.php';
        $auth = new Auth();
        if (!empty($productPromotions)):
            $stt = ($page - 1) * $limit + 1;
            foreach ($productPromotions as $row):
        ?>
                <tr data-masp="<?php echo $row['MaSP']; ?>" data-makm="<?php echo $row['MaKM']; ?>">
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo $row['MaSP']; ?></td>
                    <td><?php echo $row['TenSP']; ?></td>
                    <td><?php echo $row['MaKM']; ?></td>
                    <td><?php echo $row['TenKM']; ?></td>
                    <td>
                        <?php if ($auth->checkPermission(9, 'add')): ?>
                            <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=add">
                                <button type="button" class="btn btn-primary">Thêm</button>
                            </a>
                        <?php endif; ?>
                        <?php if ($auth->checkPermission(9, 'edit')): ?>
                            <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=edit&maSP=<?php echo $row['MaSP']; ?>&maKM=<?php echo $row['MaKM']; ?>">
                                <button type="button" class="btn btn-warning">Sửa</button>
                            </a>
                        <?php endif; ?>
                        <?php if ($auth->checkPermission(9, 'delete')): ?>
                            <a class="delete-btn" data-masp="<?php echo $row['MaSP']; ?>" data-makm="<?php echo $row['MaKM']; ?>">
                                <button type="button" class="btn btn-danger">Xóa</button>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="6">Không có sản phẩm khuyến mãi nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>>
            <?php echo $i; ?>
        </a>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
        <a href="/shoeimportsystem/public/index.php?controller=product_promotion&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
    <?php endif; ?>
</div>

<style>
    .pagination {
        margin-top: 20px;
    }

    .pagination a {
        margin: 0 5px;
        text-decoration: none;
    }

    .pagination a:hover {
        text-decoration: underline;
    }
</style>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const maSP = this.getAttribute('data-masp');
            const maKM = this.getAttribute('data-makm');
            if (confirm('Xóa sản phẩm khuyến mãi này?')) {
                fetch(`/shoeimportsystem/public/index.php?controller=product_promotion&action=delete&maSP=${maSP}&maKM=${maKM}`, {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(`tr[data-masp="${maSP}"][data-makm="${maKM}"]`).remove();
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