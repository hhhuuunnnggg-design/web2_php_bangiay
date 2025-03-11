<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
</head>
<body>
    <h1>Sửa sản phẩm</h1>
    <form method="POST" action="">
        <label>Mã sản phẩm:</label><input type="text" value="<?php echo $product['masanpham']; ?>" disabled><br>
        <label>Tên sản phẩm:</label><input type="text" name="tensanpham" value="<?php echo $product['tensanpham']; ?>" required><br>
        <label>Mô tả:</label><textarea name="mota"><?php echo $product['mota']; ?></textarea><br>
        <label>Giá bán:</label><input type="number" name="giaban" value="<?php echo $product['giaban']; ?>" required><br>
        <label>Số lượng:</label><input type="number" name="soluongconlai" value="<?php echo $product['soluongconlai']; ?>" required><br>
        <label>Màu sắc:</label>
        <select name="id_mausac" required>
            <?php foreach ($colors as $color): ?>
                <option value="<?php echo $color['id']; ?>" <?php if ($color['id'] == $product['id_mausac']) echo 'selected'; ?>>
                    <?php echo $color['tenmau']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Kích thước:</label>
        <select name="size_id" required>
            <?php foreach ($sizes as $size): ?>
                <option value="<?php echo $size['id']; ?>" <?php if ($size['id'] == $product['size_id']) echo 'selected'; ?>>
                    <?php echo $size['tensize']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label>Nhà cung cấp:</label>
        <select name="manhacungcap" required>
            <?php foreach ($suppliers as $supplier): ?>
                <option value="<?php echo $supplier['manhacungcap']; ?>" <?php if ($supplier['manhacungcap'] == $product['manhacungcap']) echo 'selected'; ?>>
                    <?php echo $supplier['tensanpham']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <button type="submit">Cập nhật</button>
    </form>
    <a href="/shoeimportsystem/public/index.php?controller=product&action=index">Quay lại</a>
</body>
</html>