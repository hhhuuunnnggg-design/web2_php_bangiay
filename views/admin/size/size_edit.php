<h1>Sửa kích thước</h1>
<form id="editSizeForm">
    <label>Mã kích thước hiện tại:</label><input type="number" value="<?php echo $size['MaSize']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $size['MaSize']; ?>">
    <label>Mã kích thước mới:</label><input type="number" name="MaSize" value="<?php echo $size['MaSize']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editSizeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=size&action=edit&id=${id}`, {
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