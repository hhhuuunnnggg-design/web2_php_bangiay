<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm</title>
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
</head>
<body>
    <h1>Thêm sản phẩm mới</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>Tên sản phẩm:</label><input type="text" name="tensanpham" required><br>
        <label>Mô tả:</label><textarea name="mota"></textarea><br>
        <label>Giá bán:</label><input type="number" name="giaban" required><br>
        <label>Số lượng:</label><input type="number" name="soluongconlai" required><br>
        <label>Màu sắc:</label>
        <select name="id_mausac" required>
            <?php foreach ($colors as $color): ?>
                <option value="<?php echo $color['id']; ?>"><?php echo $color['tenmau']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Kích thước:</label>
        <select name="size_id" required>
            <?php foreach ($sizes as $size): ?>
                <option value="<?php echo $size['id']; ?>"><?php echo $size['tensize']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Nhà cung cấp:</label>
        <select name="manhacungcap" required>
            <?php foreach ($suppliers as $supplier): ?>
                <option value="<?php echo $supplier['manhacungcap']; ?>"><?php echo $supplier['tensanpham']; ?></option>
            <?php endforeach; ?>
        </select><br>
        <label>Ảnh sản phẩm:</label><input type="file" name="anh" accept="image/*"><br>
        <button type="submit">Thêm</button>
    </form>
    <a href="/shoeimportsystem/public/index.php?controller=product&action=index">Quay lại</a>
</body>
</html>