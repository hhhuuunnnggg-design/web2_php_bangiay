<h1>Thêm khuyến mãi mới</h1>
<form id="addPromotionForm">
    <label>Tên khuyến mãi:</label>
    <input type="text" name="TenKM" required><br>
    <label>Mô tả:</label>
    <input type="text" name="MoTa"><br>
    <label>Khuyến mãi (%):</label>
    <input type="number" name="KM_PT" min="0" max="100"><br>
    <label>Tiền khuyến mãi (VNĐ):</label>
    <input type="number" name="TienKM" min="0"><br>
    <label>Ngày bắt đầu:</label>
    <input type="date" name="NgayBD" required><br>
    <label>Ngày kết thúc:</label>
    <input type="date" name="NgayKT" required><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addPromotionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=promotion&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm khuyến mãi thành công!</p>';
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