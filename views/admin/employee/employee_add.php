<h1>Thêm nhân viên mới</h1>
<form id="addEmployeeForm">
    <label>Tên nhân viên:</label><input type="text" name="TenNV" required><br>
    <label>Email:</label><input type="email" name="Email" required><br>
    <label>SĐT:</label><input type="number" name="SDT" required><br>
    <label>Địa chỉ:</label><textarea name="DiaChi" required></textarea><br>
    <label>Mật khẩu:</label><input type="password" name="MatKhau" required><br>
    <label>Quyền:</label>
    <select name="Quyen" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>"><?php echo $role['Ten']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=employee&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm nhân viên thành công!</p>';
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