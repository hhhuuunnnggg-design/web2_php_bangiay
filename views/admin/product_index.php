
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
</head>
<body>
    <h1>Quản lý sản phẩm</h1>
    <a href="/shoeimportsystem/public/index.php?controller=product&action=add">Thêm sản phẩm</a> | 
    <a href="/shoeimportsystem/public/index.php?controller=color&action=index">Quản lý màu sắc</a> | 
    <a href="/shoeimportsystem/public/index.php?controller=size&action=index">Quản lý kích thước</a>

    <form method="GET" action="">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm kiếm sản phẩm">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="index">
        <button type="submit">Tìm</button>
    </form>

    <table border="1">
        <tr>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Mô tả</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Màu sắc</th>
            <th>Kích thước</th>
            <th>Nhà cung cấp</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($products as $row): ?>
        <tr>
            <td><?php echo $row['masanpham']; ?></td>
            <td><?php echo $row['tensanpham']; ?></td>
            <td><?php echo $row['mota']; ?></td>
            <td><?php echo number_format($row['giaban'], 2); ?></td>
            <td><?php echo $row['soluongconlai']; ?></td>
            <td><?php echo $row['tenmau']; ?></td>
            <td><?php echo $row['tensize']; ?></td>
            <td><?php echo $row['nhacungcap']; ?></td>
            <td>
                <a href="/shoeimportsystem/public/index.php?controller=product&action=edit&id=<?php echo $row['masanpham']; ?>">Sửa</a>
                <a href="/shoeimportsystem/public/index.php?controller=product&action=delete&id=<?php echo $row['masanpham']; ?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>