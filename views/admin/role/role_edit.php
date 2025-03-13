<h1>Sửa quyền</h1>
<form id="editRoleForm">
    <label>ID:</label><input type="text" value="<?php echo $role['id']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
    <label>Tên quyền:</label><input type="text" name="Ten" value="<?php echo $role['Ten']; ?>" required><br>
    <label>Mô tả:</label><textarea name="MoTa"><?php echo $role['MoTa']; ?></textarea><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=role&action=edit&id=${id}`, {
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