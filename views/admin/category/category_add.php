<h1>Thêm danh mục mới</h1>
<form id="addCategoryForm">
    <label>Tên danh mục:</label><input type="text" name="TenDM" required><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=category&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm danh mục thành công!</p>';
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