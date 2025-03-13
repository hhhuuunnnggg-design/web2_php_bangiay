<h1>Sửa nhân viên</h1>
<form id="editEmployeeForm">
    <label>Mã NV:</label><input type="text" value="<?php echo $employee['MaNV']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $employee['MaNV']; ?>">
    <label>Tên nhân viên:</label><input type="text" name="TenNV" value="<?php echo $employee['TenNV']; ?>" required><br>
    <label>Email:</label><input type="email" name="Email" value="<?php echo $employee['Email']; ?>" required><br>
    <label>SĐT:</label><input type="number" name="SDT" value="<?php echo $employee['SDT']; ?>" required><br>
    <label>Địa chỉ:</label><textarea name="DiaChi" required><?php echo $employee['DiaChi']; ?></textarea><br>
    <label>Mật khẩu:</label><input type="password" name="MatKhau" value="<?php echo $employee['MatKhau']; ?>" required><br>
    <label>Quyền:</label>
    <select name="Quyen" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $employee['Quyen']) echo 'selected'; ?>>
                <?php echo $role['Ten']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editEmployeeForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=employee&action=edit&id=${id}`, {
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