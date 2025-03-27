<!-- shoeimportsystem/views/client/layout/navigation.php -->

<div style="display: flex; gap: 20px; justify-content: center; align-items: center;">
    <h2 style="margin-right: 20px;"><a href="/shoeimportsystem/index.php?controller=cart&action=index" class="nav-link">Giỏ hàng của bạn</a></h2>
    <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=index" class="nav-link position-relative me-4 my-auto" id="order-history-icon">Lịch sử mua hàng</a></h2>
    <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=canceled" class="nav-link position-relative me-4 my-auto" id="canceled-orders-icon">Đơn hàng đã hủy</a></h2>
    <h2><a href="/shoeimportsystem/index.php?controller=orderhistory&action=shipping" class="nav-link position-relative me-4 my-auto" id="shipping-orders-icon">Đơn đang vận chuyển</a></h2>
</div>

<script>
    // Hàm cập nhật màu sắc dựa trên URL hiện tại
    function updateNavStyles() {
        const currentUrl = window.location.href; // Lấy URL hiện tại
        const navLinks = document.querySelectorAll('.nav-link'); // Chọn tất cả các liên kết điều hướng

        navLinks.forEach(link => {
            const parentHeading = link.parentElement; // Lấy thẻ h2 cha
            if (link.href === currentUrl) {
                // Nếu liên kết trùng với URL hiện tại, đặt màu đen
                parentHeading.style.background = 'cornsilk';
                parentHeading.style.fontWeight = 'bold'; // Tùy chọn: làm đậm để nổi bật
            } else {
                // Các liên kết khác đặt màu xanh
                parentHeading.style.color = '#007bff';
                parentHeading.style.fontWeight = 'normal';
            }
        });
    }

    // Gọi hàm khi trang tải và khi nhấp vào liên kết
    document.addEventListener('DOMContentLoaded', updateNavStyles); // Khi trang tải
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            // Cập nhật ngay lập tức khi nhấp (trước khi chuyển trang)
            const parentHeading = this.parentElement;
            parentHeading.style.color = '#000000';
            parentHeading.style.fontWeight = 'bold';
            updateNavStyles(); // Cập nhật lại toàn bộ
        });
    });
</script>

<style>
    /* Đảm bảo màu áp dụng cho cả h2 và liên kết bên trong */
    .nav-link {
        text-decoration: none;
        /* Bỏ gạch chân mặc định */
    }

    div h2 {
        transition: color 0.3s ease;
        /* Hiệu ứng chuyển màu mượt mà */
    }
</style>