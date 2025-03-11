<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý kích thước</title>
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
</head>
<body>
    <h1>Quản lý kích thước</h1>
    <form method="POST" action="">
        <input type="text" name="tensize" placeholder="Tên kích thước" required>
        <button type="submit" name="add_size">Thêm</button>
    </form>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Tên kích thước</th>
            <th>Hành động</th>
        </tr>
        <?php foreach ($sizes as $row): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['tensize']; ?></td>
            <td>
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="text" name="tensize" value="<?php echo $row['tensize']; ?>" required>
                    <button type="submit" name="edit_size">Sửa</button>
                </form>
                <a href="/shoeimportsystem/public/index.php?controller=size&action=index&delete=<?php echo $row['id']; ?>" onclick="return confirm('Xóa kích thước này?')">Xóa</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="/shoeimportsystem/public/index.php?controller=product&action=index">Quay lại</a>
</body>
</html>