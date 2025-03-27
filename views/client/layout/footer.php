</main>
<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5">
    <div class="container py-5">
        <div class="mb-4 pb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
            <div class="g-4 row">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <div class="position-relative mx-auto">
                    </div>
                </div>
            </div>
        </div>
        <div class="g-5 row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Myshoes.vn - Giày Chính Hãng</h4>
                    <p class="mb-4">Myshoes.vn được định hướng trở thành hệ thống thương mại điện tử bán giày chính hãng hàng đầu Việt Nam..</p>
                    <a href="" class="btn border-secondary rounded-pill text-primary px-4 py-2">Đọc thêm</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Thông tin cửa hàng</h4>
                    <a class="btn-link" href="">Về chúng tôi</a>
                    <a class="btn-link" href="/shoeimportsystem/index.php?controller=contact&action=index">Liên hệ với chúng tôi</a>
                    <a class="btn-link" href="">Chính sách bảo mật</a>
                    <a class="btn-link" href="">Điều khoản & Điều kiện</a>
                    <a class="btn-link" href="">Chính sách đổi trả</a>
                    <a class="btn-link" href="">Hỗ trợ khách hàng</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Tài khoản</h4>
                    <a class="btn-link" href="">Tài khoản của tôi</a>
                    <a class="btn-link" href="/shoeimportsystem/index.php?controller=shopdetail&action=index">Thông tin cửa hàng</a>
                    <a class="btn-link" href="">Giỏ hàng</a>
                    <a class="btn-link" href="">Sản phẩm yêu thích</a>
                    <a class="btn-link" href="">Lịch sử đơn hàng</a>
                    <a class="btn-link" href="">Đơn hàng quốc tế</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Liên hệ</h4>
                    <p>Địa chỉ: 273 An Dương Vương, P.2, Q.5, TP. Hồ Chí Minh</p>
                    <p>Email: nguyendinhhungtc2020@gmail.com</p>
                    <p>Phone: (028) 38-303-108</p>
                    <p>Đã thanh toán</p>
                    <img src="img/payment.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->
<!-- <script src="/shoeimportsystem/public/js/script.js"></script> -->
<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/shoeimportsystem/views/client/layout/lib/easing/easing.min.js"></script>
<script src="/shoeimportsystem/views/client/layout/lib/waypoints/waypoints.min.js"></script>
<script src="/shoeimportsystem/views/client/layout/lib/lightbox/js/lightbox.min.js"></script>
<script src="/shoeimportsystem/views/client/layout/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedCategory = urlParams.get('category');

        if (selectedCategory) {
            document.querySelectorAll('.category-section').forEach(section => {
                if (section.id !== `category-${selectedCategory}`) {
                    section.classList.add('hidden');
                }
            });
        }
    });

    document.getElementById('cart-icon').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('/shoeimportsystem/index.php?controller=cart&action=getCartDetails')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let cartHtml = '';
                    if (data.items.length > 0) {
                        cartHtml = data.items.map(item => `
                        <div class="cart-item mb-3">
                            <img src="/shoeimportsystem/public/${item.AnhNen}" alt="${item.TenSP}" style="width: 50px; height: 50px;">
                            <span>${item.TenSP} - Size: ${item.Size} - Màu: ${item.MaMau} - Số lượng: ${item.SoLuong}</span>
                            <span class="float-end">${item.GiaKhuyenMai.toLocaleString('vi-VN')} VNĐ</span>
                        </div>
                    `).join('');
                    } else {
                        cartHtml = '<p>Giỏ hàng trống!</p>';
                    }
                    document.getElementById('cart-details').innerHTML = cartHtml;
                    $('#cartModal').modal('show');
                } else {
                    alert(data.message || 'Không thể tải giỏ hàng!');
                }
            })
            .catch(error => alert('Lỗi: ' + error));
    });
</script>

<style>
    .user-menu {
        position: relative;
        display: inline-block;
    }

    .user-menu .dropdown {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        min-width: 120px;
    }

    .user-menu:hover .dropdown {
        display: block;
    }

    .user-menu .dropdown a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #333;
    }

    .user-menu .dropdown a:hover {
        background: #f0f0f0;
    }

    /* start style liveAlert ::placeholder */
    #liveAlertPlaceholder {
        position: fixed;
        top: 10px;
        right: 10px;
        z-index: 1050;
        /* Đảm bảo nó nằm trên các thành phần khác */
        width: auto;
        max-width: 300px;
        padding: 10px;
        /* Màu nền cảnh báo */
        color: #721c24;
        /* Màu chữ cảnh báo */
        border-radius: 5px;
        margin-top: 70px;
    }

    /* end style live Alert ::placeholder */

    /* start icon alert Warning */
    .bi-exclamation-triangle-fill {
        width: 16px;
        /* Chiều rộng */
        height: 16px;
        /* Chiều cao */
    }

    /* end icon alert Warning */

    /* start icon succsuse */
    .flex-shrink-0 {
        width: 16px;
        /* Chiều rộng */
        height: 16px;
        /* Chiều cao */
    }

    /* end icon succsuse */

    /* start search */
    .searchBox {
        display: flex;
        align-items: center;
        max-width: 280px;
        width: 100%;
        background: #dfb2ba;
        border-radius: 50px;

        position: relative;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease-in-out;
    }

    .searchBox:hover {
        /* background: #b5707c; */
        box-shadow: 0px 6px 14px rgba(0, 0, 0, 0.3);
    }

    .searchInput {
        flex: 1;
        border: none;
        background: none;
        outline: none;
        color: white;
        font-size: 16px;
        margin-left: 15px;

    }

    .searchInput::placeholder {
        color: rgba(255, 255, 255, 0.6);
        /* color: pink; */
        font-style: italic;
    }

    .btn-search {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;

        border: none;
        transition: all 0.3s ease-in-out;
    }

    .btn-search i {
        font-size: 18px;
        color: white;
        transition: color 0.3s;
    }

    .btn-search:hover {
        background: linear-gradient(135deg, #009EFD 0%, #2AF598 100%);
        transform: scale(1.1);
    }

    .btn-search:active {
        transform: scale(0.95);
    }




    /* end search */
</style>


</body>

</html>