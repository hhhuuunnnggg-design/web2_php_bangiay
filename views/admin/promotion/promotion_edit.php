<h1>Sửa khuyến mãi</h1>
<form id="editPromotionForm">
    <label>Mã khuyến mãi:</label>
    <input type="text" value="<?php echo $promotion['MaKM']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $promotion['MaKM']; ?>">
    <label>Tên khuyến mãi:</label>
    <input type="text" name="TenKM" value="<?php echo $promotion['TenKM']; ?>" required><br>
    <label>Mô tả:</label>
    <input type="text" name="MoTa" value="<?php echo $promotion['MoTa'] ?? ''; ?>"><br>
    <label>Khuyến mãi (%):</label>
    <input type="number" name="KM_PT" value="<?php echo $promotion['KM_PT'] ?? ''; ?>" min="0" max="100"><br>
    <label>Tiền khuyến mãi (VNĐ):</label>
    <input type="number" name="TienKM" value="<?php echo $promotion['TienKM'] ?? ''; ?>" min="0"><br>
    <label>Ngày bắt đầu:</label>
    <input type="date" name="NgayBD" value="<?php echo $promotion['NgayBD']; ?>" required><br>
    <label>Ngày kết thúc:</label>
    <input type="date" name="NgayKT" value="<?php echo $promotion['NgayKT']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editPromotionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=promotion&action=edit&id=${id}`, {
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