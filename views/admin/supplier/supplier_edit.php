<h1>Sửa nhà cung cấp</h1>
<form id="editSupplierForm">
    <label>Mã NCC:</label><input type="text" value="<?php echo $supplier['MaNCC']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $supplier['MaNCC']; ?>">
    <label>Tên NCC:</label><input type="text" name="TenNCC" value="<?php echo $supplier['TenNCC']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editSupplierForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=edit&id=${id}`, {
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