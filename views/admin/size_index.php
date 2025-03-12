<h1>Quản lý kích thước</h1>
<form method="POST" action="">
    <input type="text" name="tensize" placeholder="Tên kích thước" required>
    <button type="submit" name="add_size">Thêm</button>
</form>

<table border="1">
    <tr>
        <th>STT</th>
        <th>ID Size</th>
        <th>Tên kích thước</th>
        <th>Hành động</th>
    </tr>
    <?php 
    $stt = 1; // Khởi tạo số thứ tự bắt đầu từ 1
    foreach ($sizes as $row): 
    ?>
    <tr>
        <td><?php echo $stt++; ?></td> <!-- Tăng số thứ tự -->
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
