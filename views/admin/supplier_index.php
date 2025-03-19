<h1>Quản lý nhà cung cấp</h1>
<div style="display: flex;justify-content: space-between;">
    <form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tìm kiếm nhà cung cấp">
        <input type="hidden" name="controller" value="supplier">
        <input type="hidden" name="action" value="index">
        <button type="submit">Tìm</button>
    </form>

    <div>
        <?php if ($auth->checkPermission(4, 'add')): ?>
            <a href="/shoeimportsystem/public/index.php?controller=supplier&action=add">
                <button type="button" class="btn btn-primary" style="margin-top: 40px; width: 100px; height: 40px;">Thêm</button>
            </a>
        <?php endif; ?>
        <?php if ($auth->checkPermission(4, 'export')): ?>
            <a href="/shoeimportsystem/public/index.php?controller=supplier&action=export">
                <button type="button" class="btn btn-info" style="margin-top: 40px; width: 100px; height: 40px;">Export</button>
            </a>
        <?php endif; ?>
        <?php if ($auth->checkPermission(4, 'import')): ?>
            <button type="button" class="btn btn-success" style="margin-top: 40px; width: 100px; height: 40px;" onclick="document.getElementById('importModal').style.display='block'">Import</button>
        <?php endif; ?>
    </div>
</div>

<div id="message"></div>

<table border="1" id="supplierTable">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã NCC</th>
            <th>Tên NCC</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once __DIR__ . '../../../core/Auth.php';
        $auth = new Auth();
        if (!empty($suppliers)):
            $stt = ($page - 1) * $limit + 1;
            foreach ($suppliers as $row):
        ?>
                <tr data-id="<?php echo $row['MaNCC']; ?>">
                    <td><?php echo $stt++; ?></td>
                    <td><?php echo $row['MaNCC']; ?></td>
                    <td><?php echo $row['TenNCC']; ?></td>
                    <td>
                        <?php if ($auth->checkPermission(4, 'edit')): ?>
                            <a href="/shoeimportsystem/public/index.php?controller=supplier&action=edit&id=<?php echo $row['MaNCC']; ?>">
                                <button type="button" class="btn btn-warning">Sửa</button>
                            </a>
                        <?php endif; ?>
                        <?php if ($auth->checkPermission(4, 'delete')): ?>
                            <a class="delete-btn" data-id="<?php echo $row['MaNCC']; ?>">
                                <button type="button" class="btn btn-danger">Xóa</button>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;
        else: ?>
            <tr>
                <td colspan="4">Không có nhà cung cấp nào.</td>
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
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=1">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>">
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
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $totalPages; ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=supplier&action=index&search=<?php echo urlencode($search); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

<!-- Modal để import -->
<div id="importModal" style="display:none; position:fixed; top:50%; left:50%; transform:translate(-50%, -50%); background:white; padding:20px; border:1px solid #ccc;">
    <h2>Import Nhà cung cấp</h2>
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

    .pagination .page-link {
        padding: 4px 8px;
        font-size: 14px;
        color: #007bff;
        border-radius: 3px;
        border: 1px solid #dee2e6;
        transition: background-color 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }

    .pagination .page-item {
        margin: 0 2px;
    }

    .pagination {
        justify-content: flex-end;
    }

    .pagination .page-item.active .page-link {
        background-color: #007bff;
        color: #ffffff;
        border-color: #007bff;
    }

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
            if (confirm('Xóa nhà cung cấp này?')) {
                fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=delete&id=${id}`, {
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
                        console.error('Lỗi khi xóa:', error);
                        document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
                    });
            }
        });
    });

    document.getElementById('importForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const fileInput = this.querySelector('input[name="importFile"]');
        if (!fileInput.files[0].name.endsWith('.csv')) {
            document.getElementById('message').innerHTML = '<p style="color:red;">Vui lòng chọn file CSV!</p>';
            return;
        }

        let formData = new FormData(this);
        fetch('/shoeimportsystem/public/index.php?controller=supplier&action=import', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const messageDiv = document.getElementById('message');
                if (data.success) {
                    messageDiv.innerHTML = '<p style="color:green;">Import thành công!</p>';
                    closeModal();

                    // Cập nhật bảng mà không reload
                    const tbody = document.querySelector('#supplierTable tbody');
                    let stt = parseInt(tbody.querySelector('tr:last-child td:first-child')?.textContent || '0') + 1;

                    data.importedSuppliers.forEach(supplier => {
                        if (!document.querySelector(`tr[data-id="${supplier.MaNCC}"]`)) { // Tránh trùng lặp
                            const row = document.createElement('tr');
                            row.setAttribute('data-id', supplier.MaNCC);
                            row.innerHTML = `
                                <td>${stt++}</td>
                                <td>${supplier.MaNCC}</td>
                                <td>${supplier.TenNCC}</td>
                                <td>
                                    ${<?php echo $auth->checkPermission(4, 'edit') ? 'true' : 'false'; ?> ? 
                                        '<a href="/shoeimportsystem/public/index.php?controller=supplier&action=edit&id=' + supplier.MaNCC + '"><button type="button" class="btn btn-warning">Sửa</button></a>' : ''}
                                    ${<?php echo $auth->checkPermission(4, 'delete') ? 'true' : 'false'; ?> ? 
                                        '<a class="delete-btn" data-id="' + supplier.MaNCC + '"><button type="button" class="btn btn-danger">Xóa</button></a>' : ''}
                                </td>
                            `;
                            tbody.appendChild(row);

                            // Gắn sự kiện xóa cho nút mới
                            const deleteBtn = row.querySelector('.delete-btn');
                            if (deleteBtn) {
                                deleteBtn.addEventListener('click', function() {
                                    const id = this.getAttribute('data-id');
                                    if (confirm('Xóa nhà cung cấp này?')) {
                                        fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=delete&id=${id}`, {
                                                method: 'POST'
                                            })
                                            .then(res => res.json())
                                            .then(result => {
                                                if (result.success) {
                                                    row.remove();
                                                    messageDiv.innerHTML = '<p style="color:green;">Xóa thành công!</p>';
                                                } else {
                                                    messageDiv.innerHTML = '<p style="color:red;">Lỗi: ' + result.message + '</p>';
                                                }
                                            })
                                            .catch(err => {
                                                console.error('Lỗi khi xóa:', err);
                                                messageDiv.innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + err.message + '</p>';
                                            });
                                    }
                                });
                            }
                        }
                    });
                } else {
                    messageDiv.innerHTML = '<p style="color:red;">Lỗi: ' + (data.message || 'Không xác định') + '</p>';
                }
            })
            .catch(error => {
                console.error('Lỗi khi import:', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
            });
    });

    function closeModal() {
        document.getElementById('importModal').style.display = 'none';
    }
</script>