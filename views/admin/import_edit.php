<h1>Sửa phiếu nhập</h1>
<form id="editImportForm">
    <input type="hidden" name="id" value="<?php echo $import['MaPN']; ?>">
    <label>Mã phiếu nhập:</label>
    <input type="text" value="<?php echo $import['MaPN']; ?>" disabled><br>
    <label>Mã nhân viên:</label>
    <input type="text" name="MaNV" value="<?php echo $import['MaNV']; ?>" required><br>
    <label>Mã sản phẩm:</label>
    <input type="text" name="MaSP" value="<?php echo $import['MaSP']; ?>" required><br>
    <label>Số lượng:</label>
    <input type="number" name="SoLuong" value="<?php echo $import['SoLuong']; ?>" min="1" required><br>
    <label>Đơn giá (VNĐ):</label>
    <input type="number" name="DonGia" value="<?php echo $import['DonGia']; ?>" min="0" required><br>
    <label>Tổng tiền (VNĐ):</label>
    <input type="text" value="<?php echo number_format($import['TongTien'], 0, ',', '.'); ?>" disabled><br>
    <label>Ngày nhập:</label>
    <input type="text" value="<?php echo $import['NgayNhap']; ?>" disabled><br>
    <label>Ghi chú:</label>
    <textarea name="Note"><?php echo $import['Note'] ?? ''; ?></textarea><br>
    <label>Size:</label>
    <input type="text" name="Size" value="<?php echo $import['Size']; ?>" required><br>
    <label>Màu:</label>
    <input type="text" name="Mau" value="<?php echo $import['Mau']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editImportForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=import&action=edit&id=${id}`, {
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