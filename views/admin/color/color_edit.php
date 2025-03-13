<h1>Sửa màu sắc</h1>
<form id="editColorForm">
    <label>Mã màu hiện tại:</label><input type="text" value="<?php echo $color['MaMau']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $color['MaMau']; ?>">
    <label>Mã màu mới:</label><input type="text" name="MaMau" value="<?php echo $color['MaMau']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editColorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=color&action=edit&id=${encodeURIComponent(id)}`, {
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