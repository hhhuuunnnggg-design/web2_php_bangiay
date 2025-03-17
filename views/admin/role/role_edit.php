<head>
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

</head>
<h1>Sửa quyền</h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=role&action=index">
            Quản lý quyền
        </a>
    </li>
</ul>
<form id="editRoleForm">
    <label>ID:</label><input type="text" value="<?php echo $role['id']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $role['id']; ?>">
    <label>Tên quyền:</label><input type="text" name="Ten" value="<?php echo $role['Ten']; ?>" required><br>
    <label>Mô tả:</label><textarea name="MoTa"><?php echo $role['MoTa']; ?></textarea><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editRoleForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=role&action=edit&id=${id}`, {
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