<h1>Thêm chi tiết quyền mới</h1>
<form id="addRoleDetailForm">
    <label>Vai trò:</label>
    <select name="manhomquyen" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['Ten']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Chức năng:</label>
    <select name="chucnang" required>
        <?php foreach ($functions as $function): ?>
            <option value="<?php echo $function['chucnang']; ?>"><?php echo $function['tenchucnang']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Hành động:</label>
    <select name="hanhdong" required>
        <option value="view">Xem</option>
        <option value="add">Thêm</option>
        <option value="edit">Sửa</option>
        <option value="delete">Xóa</option>
    </select><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addRoleDetailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=role_detail&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm chi tiết quyền thành công!</p>';
            this.reset();
        } else {
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('message').innerHTML = '<p style="color:red;">Quyền đã tồn tại</p>';
    });
});
</script>