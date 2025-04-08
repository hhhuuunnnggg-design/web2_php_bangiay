<head>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .menu {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            border-radius: 8px 0 0 8px;
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
            transition: color 0.3s;
        }

        .menu a:hover {
            color: #007bff;
        }

        .content {
            padding: 30px;
            background-color: white;
            border-radius: 0 8px 8px 0;
        }

        h1 {
            color: #343a40;
            margin-bottom: 20px;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .admin-info {
            text-align: right;
            margin-bottom: 20px;
            grid-column: 2;
        }

        /* CSS cho form thêm sản phẩm */
        .product-form {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }

        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            outline: none;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s;
            width: 100%;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .menu-link {
            display: block;
            width: 100%;
            padding: 12px 20px;
            text-align: left;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            transition: all 0.3s ease;
            margin-bottom: 10px;
            font-weight: 500;
        }

        .menu-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .breadcrumb li {
            display: inline-block;
        }

        /* Style for checkboxes */
        div label {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 10px;
            padding: 8px 12px;
            background-color: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #ced4da;
            cursor: pointer;
            transition: all 0.3s;
        }

        div label:hover {
            background-color: #e9ecef;
        }

        div input[type="checkbox"] {
            margin-right: 5px;
        }

        /* Message styling */
        #message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 4px;
        }

        #message p {
            margin: 0;
            padding: 10px;
            border-radius: 4px;
        }

        #message p[style*="color:green"] {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }

        #message p[style*="color:red"] {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
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