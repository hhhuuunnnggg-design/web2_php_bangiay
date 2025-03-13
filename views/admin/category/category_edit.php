<h1>Sửa danh mục</h1>
<form id="editCategoryForm">
    <label>Mã danh mục:</label><input type="text" value="<?php echo $category['MaDM']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $category['MaDM']; ?>">
    <label>Tên danh mục:</label><input type="text" name="TenDM" value="<?php echo $category['TenDM']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=category&action=edit&id=${id}`, {
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