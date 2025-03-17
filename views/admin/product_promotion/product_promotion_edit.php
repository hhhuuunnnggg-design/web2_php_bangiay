<h1>Sửa sản phẩm khuyến mãi</h1>
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