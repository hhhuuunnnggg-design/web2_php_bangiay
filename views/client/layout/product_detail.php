<?php
include __DIR__ . '/layout/header.php';

?>

<div class="container mt-5">
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($product['AnhNen'] ?? 'images/default-product.jpg'); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
        </div>
        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($product['TenSP']); ?></h1>
            <p class="text-danger fs-3"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></p>
            <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['TenDM']); ?></p>
            <p><strong>Nhà cung cấp:</strong> <?php echo htmlspecialchars($product['TenNCC']); ?></p>

            <!-- Kích thước -->
            <div class="mb-3">
                <label><strong>Kích thước:</strong></label><br>
                <?php foreach ($productDetails as $detail): ?>
                    <input type="radio" name="size" value="<?php echo $detail['MaSize']; ?>" id="size-<?php echo $detail['MaSize']; ?>">
                    <label for="size-<?php echo $detail['MaSize']; ?>"><?php echo $detail['MaSize']; ?></label>
                <?php endforeach; ?>
            </div>

            <!-- Màu sắc -->
            <div class="mb-3">
                <label><strong>Màu sắc:</strong></label><br>
                <?php foreach ($productDetails as $detail): ?>
                    <input type="radio" name="color" value="<?php echo $detail['MaMau']; ?>" id="color-<?php echo $detail['MaMau']; ?>">
                    <label for="color-<?php echo $detail['MaMau']; ?>"><?php echo $detail['MaMau']; ?></label>
                <?php endforeach; ?>
            </div>

            <!-- Số lượng -->
            <div class="mb-3">
                <label><strong>Số lượng:</strong></label>
                <div class="input-group w-25">
                    <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity()">-</button>
                    <input type="number" class="form-control text-center" id="quantity" value="1" min="1">
                    <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity()">+</button>
                </div>
            </div>

            <!-- Nút thêm giỏ hàng và mua ngay -->
            <div class="mb-3">
                <button class="btn btn-primary me-2" onclick="addToCart(<?php echo $product['MaSP']; ?>)">Thêm vào giỏ hàng</button>
                <button class="btn btn-success" onclick="buyNow(<?php echo $product['MaSP']; ?>)">Mua ngay</button>
            </div>
        </div>
    </div>
</div>

<script>
function increaseQuantity() {
    let quantity = document.getElementById('quantity');
    quantity.value = parseInt(quantity.value) + 1;
}

function decreaseQuantity() {
    let quantity = document.getElementById('quantity');
    if (parseInt(quantity.value) > 1) {
        quantity.value = parseInt(quantity.value) - 1;
    }
}

function addToCart(productId) {
    let size = document.querySelector('input[name="size"]:checked')?.value;
    let color = document.querySelector('input[name="color"]:checked')?.value;
    let quantity = document.getElementById('quantity').value;
    if (!size || !color) {
        alert('Vui lòng chọn kích thước và màu sắc!');
        return;
    }
    // Logic thêm vào giỏ hàng (có thể gửi AJAX request đến server)
    alert(`Đã thêm sản phẩm ${productId} vào giỏ hàng với size: ${size}, màu: ${color}, số lượng: ${quantity}`);
}

function buyNow(productId) {
    let size = document.querySelector('input[name="size"]:checked')?.value;
    let color = document.querySelector('input[name="color"]:checked')?.value;
    let quantity = document.getElementById('quantity').value;
    if (!size || !color) {
        alert('Vui lòng chọn kích thước và màu sắc!');
        return;
    }
    // Logic chuyển hướng đến trang thanh toán
    window.location.href = `/shoeimportsystem/index.php?controller=checkout&action=index&product=${productId}&size=${size}&color=${color}&quantity=${quantity}`;
}
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>