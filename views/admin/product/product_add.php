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
            background-color: #007bff;
            /* Màu nền xanh dương */
            color: #ffffff;
            /* Màu chữ trắng */
            text-decoration: none;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s ease;
        }

        .menu-link:hover {
            background-color: #0056b3;
            /* Màu nền xanh dương đậm hơn khi hover */
        }
    </style>

</head>

<h1>Thêm sản phẩm mới</h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=product&action=index">
            Quản lý sản phẩm
        </a>
    </li>
</ul>
<form id="addProductForm" enctype="multipart/form-data">
    <label>Tên sản phẩm:</label>
    <input type="text" name="TenSP" required><br>

    <label>Danh mục:</label>
    <select name="MaDM">
        <option value="">Không chọn</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['MaDM']; ?>"><?php echo $category['TenDM']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label>Nhà cung cấp:</label>
    <select name="MaNCC" required>
        <?php foreach ($suppliers as $supplier): ?>
            <option value="<?php echo $supplier['MaNCC']; ?>"><?php echo $supplier['TenNCC']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <!-- Size dưới dạng checkbox -->
    <label>Size:</label>
    <div>
        <?php foreach ($sizes as $size): ?>
            <label>
                <input type="checkbox" name="MaSize[]" value="<?php echo $size['MaSize']; ?>">
                <?php echo $size['MaSize']; ?>
            </label>
        <?php endforeach; ?>
    </div><br>

    <!-- Màu dưới dạng checkbox -->
    <label>Màu:</label>
    <div>
        <?php foreach ($colors as $color): ?>
            <label>
                <input type="checkbox" name="MaMau[]" value="<?php echo $color['MaMau']; ?>">
                <?php echo $color['MaMau']; ?>
            </label>
        <?php endforeach; ?>
    </div><br>

    <label>Mô tả:</label>
    <textarea name="MoTa"></textarea><br>

    <label>Đơn giá (VNĐ):</label>
    <input type="number" name="DonGia" min="0" required><br>

    <label>Ảnh nền:</label>
    <input type="file" name="AnhNen" accept="image/*"><br>

    <button type="submit">Thêm</button>
</form>

<div id="message"></div>

<script>
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('/shoeimportsystem/public/index.php?controller=product&action=add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').innerHTML = '<p style="color:green;">Thêm sản phẩm thành công!</p>';
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