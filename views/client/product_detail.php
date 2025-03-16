<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="/shoeimportsystem/views/client/layout/css/style.css" rel="stylesheet">
</head>
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

            <?php
            $sizes = array_filter($productDetails, function($detail) {
                return isset($detail['MaSize']);
            });
            $colors = array_filter($productDetails, function($detail) {
                return isset($detail['MaMau']);
            });
            ?>
             <!-- Kích thước -->
            <div class="mb-3">
                <label><strong>Kích thước:</strong></label><br>
                <?php
                $sizes = array_filter($productDetails, function($detail) {
                    return isset($detail['MaSize']); // Kiểm tra nếu có MaSize
                });
                foreach ($sizes as $size):
                ?>
                    <input type="radio" name="size" value="<?php echo $size['MaSize']; ?>" id="size-<?php echo $size['MaSize']; ?>">
                    <label for="size-<?php echo $size['MaSize']; ?>"><?php echo $size['MaSize']; ?></label>
                <?php endforeach; ?>
            </div>

            <!-- Màu sắc -->
            <div class="mb-3">
                <label><strong>Màu sắc:</strong></label><br>
                <?php
                $colors = array_filter($productDetails, function($detail) {
                    return isset($detail['MaMau']); // Kiểm tra nếu có MaMau
                });
                foreach ($colors as $color):
                ?>
                    <input type="radio" name="color" value="<?php echo $color['MaMau']; ?>" id="color-<?php echo $color['MaMau']; ?>">
                    <label for="color-<?php echo $color['MaMau']; ?>"><?php echo $color['MaMau']; ?></label>
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
<div class="product-details">
        <div class="description-reviews">
            <div class="tabs">
                <button class="tab-button active" data-tab="description">MÔ TẢ</button>
                <button class="tab-button" data-tab="reviews">ĐÁNH GIÁ</button>
            </div>

            <div class="tab-content" id="description">
                <p><?php echo htmlspecialchars($product['MoTa']); ?></p>
            </div>

            <div class="tab-content hidden" id="reviews">
                <textarea placeholder="Viết đánh giá..."></textarea>
                <button class="review-button">Đánh giá</button>
                <p class="no-reviews">CHƯA CÓ ĐÁNH GIÁ NÀO</p>
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
// Thêm JavaScript để xử lý các tab như trong ví dụ trước
const tabButtons = document.querySelectorAll('.tab-button');
const tabContents = document.querySelectorAll('.tab-content');

tabButtons.forEach(button => {
    button.addEventListener('click', () => {
        const tab = button.dataset.tab;

        // Ẩn tất cả nội dung tab
        tabContents.forEach(content => {
            content.classList.add('hidden');
        });

        // Hiển thị nội dung tab được chọn
        document.getElementById(tab).classList.remove('hidden');

        // Đánh dấu nút tab được chọn là active
        tabButtons.forEach(btn => {
            btn.classList.remove('active');
        });
        button.classList.add('active');
    });
});
</script>

<?php
include __DIR__ . '/layout/footer.php';
?>