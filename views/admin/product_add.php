<h1>Thêm sản phẩm mới</h1>
<form id="addProductForm" enctype="multipart/form-data">
    
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
            <option value="<?php echo $supplier['manhacungcap']; ?>"><?php echo $supplier['tennhacungcap']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Ảnh sản phẩm:</label><input type="file" name="anh" accept="image/*"><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=product&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm sản phẩm thành công!</p>';
            this.reset();
            // Tùy chọn: Gọi hàm cập nhật danh sách nếu cần
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