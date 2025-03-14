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
        <tr>
            <td><?php echo $stt++; ?></td>
            <td><?php echo $row['MaSP']; ?></td>
            <td><?php echo $row['TenSP']; ?></td>
            <td><?php echo $row['MaSize']; ?></td>
            <td><?php echo $row['MaMau']; ?></td>
            <td><?php echo $row['SoLuong']; ?></td>
        </tr>
        <?php 
            endforeach;
        else: 
        ?>
            <tr><td colspan="6">Không có chi tiết sản phẩm nào.</td></tr>
        <?php endif; ?>
    </tbody>
</table>




<div class="pagination-container">
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-sm justify-content-end">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $page - 1; ?>">Trang trước</a>
                </li>
            <?php endif; ?>

            <?php if ($page > 3): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=1">1</a>
                </li>
                <?php if ($page > 4): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endif; ?>

            <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $i; ?>">
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
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $totalPages; ?>">
                        <?php echo $totalPages; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="/shoeimportsystem/public/index.php?controller=product_detail&action=index&search_name=<?php echo urlencode($search_name); ?>&search_color=<?php echo urlencode($search_color); ?>&search_size=<?php echo urlencode($search_size); ?>&page=<?php echo $page + 1; ?>">Trang sau</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>




<style>
    .pagination { margin-top: 20px; }
    .pagination a { margin: 0 5px; text-decoration: none; }
    .pagination a:hover { text-decoration: underline; }
</style>

<style>
    .pagination-container {
        margin-top: 20px;
    }

    /* Kích thước nhỏ hơn */
    .pagination .page-link {
        padding: 4px 10px;
        font-size: 14px;
    }

    /* Giảm khoảng cách giữa các nút */
    .pagination .page-item {
        margin: 0 2px;
    }

    /* Căn về phía bên phải */
    .pagination {
        justify-content: flex-end;
    }
</style>



<!-- <nav aria-label="...">
  <ul class="pagination pagination-lg">
    <li class="page-item active" aria-current="page">
      <span class="page-link">1</span>
    </li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
  </ul>
</nav> -->