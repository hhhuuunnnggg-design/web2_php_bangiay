<h1>Quản lý hóa đơn</h1>
<div style="display: flex; justify-content: space-between;">
    <form method="GET" action="/shoeimportsystem/public/index.php" id="searchForm" style="display: flex; gap: 10px;">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search ?? ''); ?>" placeholder="Tên khách hàng">
        <input type="hidden" name="controller" value="order">
        <input type="hidden" name="action" value="index">

        <select name="status" class="form-select" style="width: auto;">
            <option value="">Tình trạng đơn hàng</option>
            <option value="Chờ xử lý" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Chờ xử lý') ? 'selected' : ''; ?>>Chờ xử lý</option>
            <option value="đang vận chuyển" <?php echo (isset($_GET['status']) && $_GET['status'] === 'đang vận chuyển') ? 'selected' : ''; ?>>đang vận chuyển</option>
            <option value="hoàn thành" <?php echo (isset($_GET['status']) && $_GET['status'] === 'hoàn thành') ? 'selected' : ''; ?>>Hoàn thành</option>
            <option value="Hủy Bỏ" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Hủy Bỏ') ? 'selected' : ''; ?>>Hủy bỏ</option>
        </select>

        <div class="date-range" style="display: flex; gap: 5px; align-items: center;">
            <input type="date" name="start_date" value="<?php echo isset($_GET['start_date']) ? htmlspecialchars($_GET['start_date']) : ''; ?>" class="form-control" style="width: auto;">
            <span>đến</span>
            <input type="date" name="end_date" value="<?php echo isset($_GET['end_date']) ? htmlspecialchars($_GET['end_date']) : ''; ?>" class="form-control" style="width: auto;">
        </div>

        <button type="submit" class="btn btn-primary" style="border-radius: 10px;"><i class="fa-solid fa-magnifying-glass"></i></button>

        <?php if (isset($_GET['status']) || isset($_GET['start_date']) || isset($_GET['end_date']) || isset($_GET['search'])): ?>
            <a href="/shoeimportsystem/public/index.php?controller=order&action=index" class="btn btn-secondary" style="border-radius: 10px;"><i class="fa-solid fa-delete-left"></i></a>
        <?php endif; ?>
    </form>

</div>

<div id="message"></div>

<table border="1" id="orderTable">
    <thead>
        <tr>
            <th>STT</th>

            <th>Khách hàng</th>

            <th>Shipper</th> <!-- Thêm cột Shipper -->
            <th>Ngày đặt</th>
            <th>Ngày giao</th>
            <th>Tình trạng</th>
            <th>Tổng tiền</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        require_once __DIR__ . '../../../core/Auth.php';
        $auth = new Auth();
        if (!empty($orders)):
            $stt = ($page - 1) * $limit + 1;
            foreach ($orders as $row):
        ?>
                <tr data-id="<?php echo $row['MaHD']; ?>">
                    <td><?php echo $stt++; ?></td>

                    <td><?php echo htmlspecialchars($row['TenKH']); ?></td>

                    <td><?php echo htmlspecialchars($row['TenShipper'] ?? 'Chưa gán'); ?></td> <!-- Hiển thị tên Shipper -->
                    <td><?php echo $row['NgayDat']; ?></td>
                    <td><?php echo $row['NgayGiao'] ?? 'Chưa giao'; ?></td>
                    <td>
                        <?php
                        if ($row['TinhTrang'] === 'hoàn thành') {
                            echo '<span style="color: green;">' . $row['TinhTrang'] . '</span>';
                        } elseif ($row['TinhTrang'] === 'Hủy Bỏ') {
                            echo '<span style="color: orange;">' . $row['TinhTrang'] . '</span>';
                        } else {
                            echo $row['TinhTrang'];
                        }
                        ?>
                    </td>
                    <td><?php echo number_format($row['TongTien'], 0, ',', '.') . ' VNĐ'; ?></td>
                    <td>
                        <a style="text-decoration: none;" href="/shoeimportsystem/public/index.php?controller=order&action=detail&id=<?php echo urlencode($row['MaHD']); ?>">
                            <button type="button" class="btn btn-info">Xem chi tiết</button>
                        </a>
                        <?php if ($auth->checkPermission(13, 'edit')): ?>
                            <a href="/shoeimportsystem/public/index.php?controller=order&action=edit&id=<?php echo urlencode($row['MaHD']); ?>">
                                <button type="button" class="btn btn-warning">Sửa</button>
                            </a>
                            <?php if (!$row['MaNVGH'] && $row['TinhTrang'] !== 'hoàn thành' && $row['TinhTrang'] !== 'Hủy Bỏ'): ?>
                                <a href="/shoeimportsystem/public/index.php?controller=order&action=assignShipper&id=<?php echo urlencode($row['MaHD']); ?>">
                                    <button type="button" class="btn btn-primary">Gán Shipper</button>
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="10">Không có hóa đơn nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="pagination-container">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-end">
            <?php
            // Build query string for pagination links
            $queryParams = [];
            if (!empty($search)) $queryParams['search'] = $search;
            if (!empty($status)) $queryParams['status'] = $status;
            if (!empty($start_date)) $queryParams['start_date'] = $start_date;
            if (!empty($end_date)) $queryParams['end_date'] = $end_date;
            $queryParams['controller'] = 'order';
            $queryParams['action'] = 'index';

            // Function to build pagination URL
            function buildPaginationUrl($page, $queryParams)
            {
                $queryParams['page'] = $page;
                return '/shoeimportsystem/public/index.php?' . http_build_query($queryParams);
            }
            ?>

            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo buildPaginationUrl($page - 1, $queryParams); ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo buildPaginationUrl(1, $queryParams); ?>">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="<?php echo buildPaginationUrl($i, $queryParams); ?>">
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
                    <a class="page-link" href="<?php echo buildPaginationUrl($totalPages, $queryParams); ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="<?php echo buildPaginationUrl($page + 1, $queryParams); ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

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

    .form-select {
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #fff;
    }

    .form-select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    #searchForm {
        align-items: center;
    }

    #searchForm input[type="text"] {
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        width: 300px;
    }

    #searchForm button {
        padding: 6px 12px;
    }

    .date-range {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .date-range input[type="date"] {
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: #fff;
    }

    .date-range input[type="date"]:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }
</style>