<h1>Thêm sản phẩm khuyến mãi</h1>
<form id="addProductPromotionForm">
    <label>Sản phẩm:</label>
    <select name="MaSP" required>
        <?php foreach ($products as $product): ?>
            <option value="<?php echo $product['MaSP']; ?>"><?php echo $product['TenSP']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <label>Khuyến mãi:</label>
    <select name="MaKM" required>
        <?php foreach ($promotions as $promotion): ?>
            <option value="<?php echo $promotion['MaKM']; ?>"><?php echo $promotion['TenKM']; ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Thêm</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('addProductPromotionForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        fetch('/shoeimportsystem/public/index.php?controller=product_promotion&action=add', {
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
                    document.getElementById('message').innerHTML = '<p style="color:green;">Thêm sản phẩm khuyến mãi thành công!</p>';
                    this.reset();
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