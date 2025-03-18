<h1>Quản lý màu sắc</h1>
<div style="display: flex;justify-content: space-between;">
    <form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm màu sắc">
        <input type="hidden" name="controller" value="color">
        <input type="hidden" name="action" value="index">
        <button type="submit">Tìm</button>
    </form>

    <div>
        <?php if ($auth->checkPermission(2, 'add')): ?>
            <a href="/shoeimportsystem/public/index.php?controller=color&action=add" style="text-decoration: none;">
                <button type="button" class="btn btn-primary" style="margin-top: 40px; width: 100px; height: 40px;">Thêm</button>
            </a>
        <?php endif; ?>
        <?php if ($auth->checkPermission(2, 'export')): ?>
            <a href="/shoeimportsystem/public/index.php?controller=color&action=export">
                <button type="button" class="btn btn-info" style="margin-top: 40px; width: 100px; height: 40px;">Export</button>
            </a>
        <?php endif; ?>
        <?php if ($auth->checkPermission(2, 'import')): ?>
            <button type="button" class="btn btn-success" style="margin-top: 40px; width: 100px; height: 40px;" onclick="document.getElementById('importModal').style.display='block'">Import</button>
        <?php endif; ?>
    </div>



</div>

<div id="message"></div>

<table border="1" id="colorTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã màu</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once __DIR__ . '../../../core/Auth.php'; // Đường dẫn tới Auth.php
        if (!empty($colors)):
            $stt = ($page - 1) * $limit + 1;
            foreach ($colors as $row):
        ?>
                <tr data-id="<?php echo $row['MaMau']; ?>">
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo $row['MaMau']; ?></td>
                    <td>
                        <?php if ($auth->checkPermission(2, 'edit')): ?>
                            <a href="/shoeimportsystem/public/index.php?controller=color&action=edit&id=<?php echo urlencode($row['MaMau']); ?>">
                                <button type="button" class="btn btn-warning">Sửa</button>
                            </a>
                        <?php endif; ?>

                        <?php if ($auth->checkPermission(2, 'delete')): ?>
                            <a class="delete-btn" data-id="<?php echo urlencode($row['MaMau']); ?>">
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
                <td colspan="3">Không có màu sắc nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="pagination-container">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-end">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=color&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=color&action=index&search=<?php echo urlencode($search); ?>&page=1">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=color&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
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
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=color&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $totalPages; ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=color&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- Modal để import -->
<div id="importModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border:1px solid #ccc;">
    <h2>Import màu sắc</h2>
    <form id="importForm" enctype="multipart/form-data">
        <label>Chọn file CSV:</label>
        <input type="file" name="importFile" accept=".csv" required><br>
        <button type="submit">Import</button>
        <button type="button" onclick="closeModal()">Hủy</button>
    </form>
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


<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (confirm('Xóa màu sắc này?')) {
                fetch(`/shoeimportsystem/public/index.php?controller=color&action=delete&id=${id}`, {
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

        fetch('/shoeimportsystem/public/index.php?controller=color&action=import', {
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