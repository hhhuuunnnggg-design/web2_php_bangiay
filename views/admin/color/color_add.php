<h1>Thêm màu sắc mới</h1>
<form id="addColorForm">
    <label>Mã màu:</label><input type="text" name="MaMau" required><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
document.getElementById('addColorForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=color&action=add', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('message').innerHTML = '<p style="color:green;">Thêm màu sắc thành công!</p>';
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