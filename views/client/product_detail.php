<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?></title>
    <link href="/shoeimportsystem/views/client/layout/css/style.css" rel="stylesheet">
<style>
    .hidden {
    display: none;
}
</style>

</head>
<?php
include __DIR__ . '/layout/header.php';

?>

<div class="container mt-5">
<div class="breadcrumb">
            <a href="/shoeimportsystem/index.php?controller=home&action=index">Trang chủ</a> » Chi tiết sản phẩm
        </div>
    <div class="row">
        <!-- Ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="/shoeimportsystem/public/<?php echo htmlspecialchars($product['AnhNen'] ?? 'images/default-product.jpg'); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($product['TenSP']); ?>">
        </div>
        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h1><?php echo htmlspecialchars($product['TenSP']); ?></h1>
            <p class="fs-3">
                <?php if ($product['GiaKhuyenMai'] < $product['DonGia']): ?>
                    <span class="text-danger font-weight-bold"><?php echo number_format($product['GiaKhuyenMai'], 0, ',', '.') . ' VNĐ'; ?></span><br>
                    <span style="text-decoration: line-through; color: gray;"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                <?php else: ?>
                    <span class="text-danger"><?php echo number_format($product['DonGia'], 0, ',', '.') . ' VNĐ'; ?></span>
                <?php endif; ?>
            </p>
            <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product['TenDM']); ?></p>
            <p><strong>Nhà cung cấp:</strong> <?php echo htmlspecialchars($product['TenNCC']); ?></p>

            <!-- Kích thước -->
            <div class="mb-3">
                <label><strong>Kích thước:</strong></label><br>
                <?php
                $sizes = array_unique(array_column($productDetails, 'MaSize')); // Lấy danh sách kích thước duy nhất
                foreach ($sizes as $size):
                    if ($size): // Chỉ hiển thị nếu có MaSize
                ?>
                        <input type="radio" name="size" value="<?php echo $size; ?>" id="size-<?php echo $size; ?>">
                        <label for="size-<?php echo $size; ?>"><?php echo $size; ?></label>
                <?php endif;
                endforeach; ?>
            </div>

            <!-- Màu sắc -->
            <div class="mb-3">
                <label><strong>Màu sắc:</strong></label><br>
                <?php
                $colors = array_unique(array_column($productDetails, 'MaMau')); // Lấy danh sách màu duy nhất
                foreach ($colors as $color):
                    if ($color): // Chỉ hiển thị nếu có MaMau
                ?>
                        <input type="radio" name="color" value="<?php echo $color; ?>" id="color-<?php echo $color; ?>">
                        <label for="color-<?php echo $color; ?>"><?php echo $color; ?></label>
                <?php endif;
                endforeach; ?>
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
            <form id="review-form" method="post">
        <textarea name="comment" placeholder="Viết đánh giá..."></textarea><br>
        <button type="button" id="submit-review" class="review-button">Đánh giá</button>
            </form>
            <?php
            // Truy vấn đánh giá từ bảng binhluan
            $reviews = $this->model('CommentModel')->getReviewsByProductId($product['MaSP']);
            if (!empty($reviews)):
                foreach ($reviews as $review):
                    ?>
                    <div class="review">
                        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($review['MaKH']); ?></p>
                        <p><strong>Thời gian:</strong> <?php echo htmlspecialchars($review['ThoiGian']); ?></p>
                        <p><?php echo htmlspecialchars($review['NoiDung']); ?></p>
                    </div>
                <?php
                endforeach;
            else:
                ?>
                <p class="no-reviews">CHƯA CÓ ĐÁNH GIÁ NÀO</p>
            <?php endif; ?>
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

    document.getElementById('submit-review').addEventListener('click', function() {
        const form = document.getElementById('review-form');
        const comment = form.comment.value;
        const productId = <?php echo $product['MaSP']; ?>; // Lấy productId từ PHP

        fetch('/shoeimportsystem/index.php?controller=comment&action=addComment&productId=' + productId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'comment=' + encodeURIComponent(comment),
        })
        .then(response => response.json()) // Giả sử server trả về JSON
        .then(data => {
            if (data.success) {
                alert('Đánh giá của bạn đã được thêm thành công!');
                // Thêm đánh giá mới vào danh sách đánh giá mà không cần tải lại trang
                // Ví dụ:
                const reviewDiv = document.createElement('div');
                reviewDiv.classList.add('review');
                reviewDiv.innerHTML = `<p><strong>Khách hàng:</strong> ${data.MaKH}</p><p><strong>Thời gian:</strong> ${data.ThoiGian}</p><p>${comment}</p>`;
                document.querySelector('#reviews').appendChild(reviewDiv);
                form.comment.value = ''; // Xóa nội dung đánh giá sau khi gửi thành công
            } else {
                alert('Có lỗi xảy ra khi thêm đánh giá. Vui lòng thử lại.');
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi thêm đánh giá. Vui lòng thử lại.');
        });
    });

</script>

<?php
include __DIR__ . '/layout/footer.php';
?>
</html>