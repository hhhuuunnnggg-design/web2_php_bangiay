<h1>Sửa chức năng</h1>
<form id="editFunctionForm">
    <label>Mã chức năng hiện tại:</label>
    <input type="text" value="<?php echo $function['chucnang']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $function['chucnang']; ?>">
    <label>Mã chức năng mới:</label>
    <input type="number" name="chucnang" value="<?php echo $function['chucnang']; ?>" required><br>
    <label>Tên chức năng:</label>
    <input type="text" name="tenchucnang" value="<?php echo $function['tenchucnang']; ?>" required><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editFunctionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=function&action=edit&id=${id}`, {
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