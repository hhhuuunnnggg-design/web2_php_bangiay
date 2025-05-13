<h1>Quản lý phiếu nhập</h1>
<form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
    <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm theo tên sản phẩm">
    <input type="hidden" name="controller" value="import">
    <input type="hidden" name="action" value="index">
    <button type="submit">Tìm</button>
</form>

<div id="message"></div>

<table border="1" id="importTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã PN</th>
            <th>Tên NV</th>
            <th>Tên SP</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Tổng tiền</th>
            <th>Ngày nhập</th>
            <th>Ghi chú</th>
            <th>Size</th>
            <th>Màu</th>

        </tr>
    </thead>
    <tbody>
        <?php
        require_once __DIR__ . '/../../core/Auth.php';
        $auth = new Auth();
        if (!empty($imports)):
            $stt = ($page - 1) * $limit + 1;
            foreach ($imports as $row):
        ?>
                <tr data-id="<?php echo $row['MaPN']; ?>">
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo $row['MaPN']; ?></td>
                    <td><?php echo $row['TenNV']; ?></td>
                    <td><?php echo $row['TenSP']; ?></td>
                    <td><?php echo $row['SoLuong']; ?></td>
                    <td><?php echo number_format($row['DonGia'], 0, ',', '.'); ?></td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['NgayNhap']; ?></td>
                    <td><?php echo $row['Note'] ?? ''; ?></td>
                    <td><?php echo $row['Size']; ?></td>
                    <td><?php echo $row['Mau']; ?></td>

                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="12">Không có phiếu nhập nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="pagination-container">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-end">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=1">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
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
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $totalPages; ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=import&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<style>
    .pagination-container {
        margin-top: 20px;
    }

    /* Kích thước nhỏ hơn */
    .pagination .page-link {
        padding: 4px 8px;
        font-size: 14px;
        color: #007bff;
        border-radius: 3px;
        border: 1px solid #dee2e6;
        transition: background-color 0.2s ease;
    }

    /* Hiệu ứng khi di chuột */
    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }

    /* Giảm khoảng cách giữa các nút */
    .pagination .page-item {
        margin: 0 2px;
    }

    /* Căn về phía bên phải */
    .pagination {
        justify-content: flex-end;
    }

    /* Định dạng cho trang hiện tại */
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #ffffff;
        border-color: #007bff;
    }

    /* Vô hiệu hóa nút */
    .pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
</style>


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
            const id = this.getAttribute('data-id');
            if (confirm('Xóa phiếu nhập này?')) {
                fetch(`/shoeimportsystem/public/index.php?controller=import&action=delete&id=${id}`, {
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