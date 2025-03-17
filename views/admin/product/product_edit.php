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
<h1>Sửa sản phẩm</h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=product&action=index">
            Quản lý sản phẩm
        </a>
    </li>
</ul>
<form id="editProductForm" enctype="multipart/form-data">
    <label>Mã sản phẩm:</label>
    <input type="text" value="<?php echo $product['MaSP']; ?>" disabled><br>
    <input type="hidden" name="id" value="<?php echo $product['MaSP']; ?>">
    <label>Tên sản phẩm:</label>
    <input type="text" name="TenSP" value="<?php echo $product['TenSP']; ?>" required><br>
    <label>Danh mục:</label>
    <select name="MaDM">
        
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['MaDM']; ?>" <?php if ($category['MaDM'] == $product['MaDM']) echo 'selected'; ?>>
                <?php echo $category['TenDM']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Nhà cung cấp:</label>
    <select name="MaNCC" required>
        <?php foreach ($suppliers as $supplier): ?>
            <option value="<?php echo $supplier['MaNCC']; ?>" <?php if ($supplier['MaNCC'] == $product['MaNCC']) echo 'selected'; ?>>
                <?php echo $supplier['TenNCC']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Số lượng:</label>
    <input type="number" value="<?php echo $product['SoLuong']; ?>" disabled><br>
    <label>Mô tả:</label>
    <textarea name="MoTa"><?php echo $product['MoTa'] ?? ''; ?></textarea><br>
    <label>Đơn giá (VNĐ):</label>
    <input type="number" name="DonGia" value="<?php echo $product['DonGia']; ?>" min="0" required><br>
    <label>Ảnh nền hiện tại:</label>
    <?php if (!empty($product['AnhNen'])): ?>
        <img src="/shoeimportsystem/public/<?php echo $product['AnhNen']; ?>" alt="Ảnh nền" width="100"><br>
    <?php else: ?>
        Chưa có ảnh<br>
    <?php endif; ?>
    <input type="hidden" name="current_AnhNen" value="<?php echo $product['AnhNen']; ?>">
    <label>Upload ảnh mới:</label>
    <input type="file" name="AnhNen" accept="image/*"><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
document.getElementById('editProductForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = formData.get('id');

    fetch(`/shoeimportsystem/public/index.php?controller=product&action=edit&id=${id}`, {
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