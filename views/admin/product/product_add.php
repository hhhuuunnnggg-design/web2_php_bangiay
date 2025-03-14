<h1>Thêm sản phẩm mới</h1>
<form id="addProductForm" enctype="multipart/form-data">
    <label>Tên sản phẩm:</label>
    <input type="text" name="TenSP" required><br>

    <label>Danh mục:</label>
    <select name="MaDM">
        <option value="">Không chọn</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['MaDM']; ?>"><?php echo $category['TenDM']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Nhà cung cấp:</label>
    <select name="MaNCC" required>
        <?php foreach ($suppliers as $supplier): ?>
            <option value="<?php echo $supplier['MaNCC']; ?>"><?php echo $supplier['TenNCC']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <!-- Size dưới dạng checkbox -->
    <label>Size:</label>
    <div>
        <?php foreach ($sizes as $size): ?>
            <label>
                <input type="checkbox" name="MaSize[]" value="<?php echo $size['MaSize']; ?>"> 
                <?php echo $size['MaSize']; ?>
            </label>
        <?php endforeach; ?>
    </div><br>

    <!-- Màu dưới dạng checkbox -->
    <label>Màu:</label>
    <div>
        <?php foreach ($colors as $color): ?>
            <label>
                <input type="checkbox" name="MaMau[]" value="<?php echo $color['MaMau']; ?>"> 
                <?php echo $color['MaMau']; ?>
            </label>
        <?php endforeach; ?>
    </div><br>

    <label>Mô tả:</label>
    <textarea name="MoTa"></textarea><br>

    <label>Đơn giá (VNĐ):</label>
    <input type="number" name="DonGia" min="0" required><br>

    <label>Ảnh nền:</label>
    <input type="file" name="AnhNen" accept="image/*"><br>

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
