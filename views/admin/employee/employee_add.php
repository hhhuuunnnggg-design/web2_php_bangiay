<h1>Thêm nhân viên mới</h1>

<style>
body {
    background-color: white; 
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    width: 90%;
    margin: 20px auto;
    display: grid;
    grid-template-columns: 200px 1fr;
}

.menu {
    background-color: #343a40;
    color: #ffffff;
    padding: 20px;
}

.menu ul {
    list-style: none;
    padding: 0;
}

.menu li {
    padding: 10px 0;
}

.menu a {
    color: #ffffff;
    text-decoration: none;
}

.content {
    padding: 20px;
}

h1 {
    color: black;
    margin-bottom: 20px;
}

.admin-info {
    text-align: right;
    margin-bottom: 20px;
    grid-column: 2;
}

/* CSS cho trang "Thêm nhân viên mới" */
form {
    width: 500px;
    margin: 20px auto;
}

label {
    display: block;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="number"],
textarea,
select {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

button {
    background-color: #007bff;
    color: #ffffff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
}
.menu-link {
    display: block;
    width: 100%;
    padding: 10px 20px;
    text-align: left;
    background-color: #007bff; /* Màu nền xanh dương */
    color: #ffffff; /* Màu chữ trắng */
    text-decoration: none;
    border-radius: 5px;
    border: none;
    transition: background-color 0.3s ease;
}

.menu-link:hover {
    background-color: #0056b3; /* Màu nền xanh dương đậm hơn khi hover */
}
</style>

<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=employee&action=index">
            Quản lý nhân viên
        </a>
    </li>
</ul>

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