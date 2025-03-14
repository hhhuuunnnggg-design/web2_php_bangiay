<h1>Sửa chi tiết quyền</h1>
<form id="editRoleDetailForm">
    <label>Vai trò hiện tại:</label>
    <input type="text" value="<?php echo $roleDetail['manhomquyen'] . ' - ' . ($roleDetail['TenQuyen'] ?? 'Không xác định'); ?>" disabled><br>
    <input type="hidden" name="old_manhomquyen" value="<?php echo $roleDetail['manhomquyen']; ?>">
    <label>Chức năng hiện tại:</label>
    <input type="text" value="<?php echo $roleDetail['chucnang'] . ' - ' . ($roleDetail['TenChucNang'] ?? 'Không xác định'); ?>" disabled><br>
    <input type="hidden" name="old_chucnang" value="<?php echo $roleDetail['chucnang']; ?>">
    <label>Hành động hiện tại:</label>
    <input type="text" value="<?php echo $roleDetail['hanhdong']; ?>" disabled><br>
    <input type="hidden" name="old_hanhdong" value="<?php echo $roleDetail['hanhdong']; ?>">

    <label>Vai trò mới:</label>
    <select name="manhomquyen" required>
        <?php foreach ($roles as $role): ?>
            <option value="<?php echo $role['id']; ?>" <?php if ($role['id'] == $roleDetail['manhomquyen']) echo 'selected'; ?>>
                <?php echo $role['Ten']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Chức năng mới:</label>
    <select name="chucnang" required>
        <?php foreach ($functions as $function): ?>
            <option value="<?php echo $function['chucnang']; ?>" <?php if ($function['chucnang'] == $roleDetail['chucnang']) echo 'selected'; ?>>
                <?php echo $function['tenchucnang']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Hành động mới:</label>
    <select name="hanhdong" required>
        <option value="view" <?php if ($roleDetail['hanhdong'] == 'view') echo 'selected'; ?>>Xem</option>
        <option value="add" <?php if ($roleDetail['hanhdong'] == 'add') echo 'selected'; ?>>Thêm</option>
        <option value="edit" <?php if ($roleDetail['hanhdong'] == 'edit') echo 'selected'; ?>>Sửa</option>
        <option value="delete" <?php if ($roleDetail['hanhdong'] == 'delete') echo 'selected'; ?>>Xóa</option>
    </select><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editRoleDetailForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let old_manhomquyen = formData.get('old_manhomquyen');
    let old_chucnang = formData.get('old_chucnang');
    let old_hanhdong = formData.get('old_hanhdong');

    fetch(`/shoeimportsystem/public/index.php?controller=role_detail&action=edit&manhomquyen=${old_manhomquyen}&chucnang=${old_chucnang}&hanhdong=${encodeURIComponent(old_hanhdong)}`, {
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