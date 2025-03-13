<h1>Thêm quyền mới</h1>
<form id="addRoleForm">
    <label>Tên quyền:</label><input type="text" name="Ten" required><br>
    <label>Mô tả:</label><textarea name="MoTa"></textarea><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=role&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm quyền thành công!</p>';
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