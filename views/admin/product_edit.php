<h1>Sửa sản phẩm</h1>
<form id="editProductForm" enctype="multipart/form-data">
    <label>Mã sản phẩm:</label><input type="text" value="<?php echo $product['masanpham']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $product['masanpham']; ?>">
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
                <?php echo $supplier['tennhacungcap']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Ảnh hiện tại:</label>
    <?php if (!empty($product['anh'])): ?>
        <img src="/shoeimportsystem/public/<?php echo $product['anh']; ?>" alt="Ảnh sản phẩm" width="100"><br>
    <?php else: ?>
        Chưa có ảnh<br>
    <?php endif; ?>
    <input type="hidden" name="current_anh" value="<?php echo $product['anh']; ?>">
    <label>Upload ảnh mới:</label><input type="file" name="anh" accept="image/*"><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=product&action=edit&id=${id}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Cập nhật thành công!</p>';
        } else {
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra!</p>';
    });
});
</script>