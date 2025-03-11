<h1>Quản lý màu sắc</h1>
<form method="POST" action="">
    <input type="text" name="tenmau" placeholder="Tên màu" required>
    <button type="submit" name="add_color">Thêm</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên màu</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($colors as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['tenmau']; ?></td>
        <td>
            <form method="POST" action="" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="text" name="tenmau" value="<?php echo $row['tenmau']; ?>" required>
                <button type="submit" name="edit_color">Sửa</button>
            </form>
            <a href="/shoeimportsystem/public/index.php?controller=color&action=index&delete=<?php echo $row['id']; ?>" onclick="return confirm('Xóa màu này?')">Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>