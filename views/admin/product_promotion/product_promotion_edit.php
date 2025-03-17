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
<h1>Sửa sản phẩm khuyến mãi</h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=product_promotion&action=index">
            Quản lý sản phẩm khuyến mãi
        </a>
    </li>
</ul>
<form id="editProductPromotionForm">
    <label>Sản phẩm hiện tại:</label>
    <input type="text" value="<?php echo $productPromotion['MaSP'] . ' - ' . $productPromotion['TenSP']; ?>" disabled><br>
    <input type="hidden" name="oldMaSP" value="<?php echo $productPromotion['MaSP']; ?>">
    <label>Khuyến mãi hiện tại:</label>
    <input type="text" value="<?php echo $productPromotion['MaKM'] . ' - ' . $productPromotion['TenKM']; ?>" disabled><br>
    <input type="hidden" name="oldMaKM" value="<?php echo $productPromotion['MaKM']; ?>">

    <label>Sản phẩm mới:</label>
    <select name="MaSP" required>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['MaSP']; ?>" <?php if ($product['MaSP'] == $productPromotion['MaSP']) echo 'selected'; ?>>
                <?php echo $product['TenSP']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <label>Khuyến mãi mới:</label>
    <select name="MaKM" required>
        <?php foreach ($promotions as $promotion): ?>
            <option value="<?php echo $promotion['MaKM']; ?>" <?php if ($promotion['MaKM'] == $productPromotion['MaKM']) echo 'selected'; ?>>
                <?php echo $promotion['TenKM']; ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('editProductPromotionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let oldMaSP = formData.get('oldMaSP');
        let oldMaKM = formData.get('oldMaKM');

        fetch(`/shoeimportsystem/public/index.php?controller=product_promotion&action=edit&maSP=${oldMaSP}&maKM=${oldMaKM}`, { // Sửa đường dẫn
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    document.getElementById('message').innerHTML = '<p style="color:green;">Cập nhật thành công!</p>';
                } else {
                    document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + (data.message || 'Không có thông tin lỗi') + '</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
            });
    });
</script>