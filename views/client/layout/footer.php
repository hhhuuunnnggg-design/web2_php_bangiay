</main>
<!-- Footer Start -->
<div class="container-fluid bg-dark text-white-50 footer mt-5 pt-5">
    <div class="container py-5">
        <div class="mb-4 pb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
            <div class="g-4 row">
                <div class="col-lg-3">
                    <a href="#">
                        <h1 class="text-primary mb-0">Fruitables</h1>
                        <p class="text-secondary mb-0">Fresh products</p>
                    </a>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative mx-auto">
                        <input class="form-control border-0 rounded-pill w-100 px-4 py-3" type="number" placeholder="Your Email">
                        <button type="submit" class="btn btn-primary border-0 border-secondary position-absolute rounded-pill text-white px-4 py-3" style="top: 0; right: 0;">Subscribe Now</button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-flex justify-content-end pt-3">
                        <a class="btn btn-md-square btn-outline-secondary rounded-circle me-2" href=""><i class="fa-twitter fab"></i></a>
                        <a class="btn btn-md-square btn-outline-secondary rounded-circle me-2" href=""><i class="fa-facebook-f fab"></i></a>
                        <a class="btn btn-md-square btn-outline-secondary rounded-circle me-2" href=""><i class="fa-youtube fab"></i></a>
                        <a class="btn btn-md-square btn-outline-secondary rounded-circle" href=""><i class="fa-linkedin-in fab"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="g-5 row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Why People Like us!</h4>
                    <p class="mb-4">typesetting, remaining essentially unchanged. It was
                        popularised in the 1960s with the like Aldus PageMaker including of Lorem Ipsum.</p>
                    <a href="" class="btn border-secondary rounded-pill text-primary px-4 py-2">Read More</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Shop Info</h4>
                    <a class="btn-link" href="">About Us</a>
                    <a class="btn-link" href="/shoeimportsystem/index.php?controller=contact&action=index">Contact Us</a>
                    <a class="btn-link" href="">Privacy Policy</a>
                    <a class="btn-link" href="">Terms & Condition</a>
                    <a class="btn-link" href="">Return Policy</a>
                    <a class="btn-link" href="">FAQs & Help</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="d-flex flex-column text-start footer-item">
                    <h4 class="text-light mb-3">Account</h4>
                    <a class="btn-link" href="">My Account</a>
                    <a class="btn-link" href="/shoeimportsystem/index.php?controller=shopdetail&action=index">Shop details</a>
                    <a class="btn-link" href="">Shopping Cart</a>
                    <a class="btn-link" href="">Wishlist</a>
                    <a class="btn-link" href="">Order History</a>
                    <a class="btn-link" href="">International Orders</a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="footer-item">
                    <h4 class="text-light mb-3">Contact</h4>
                    <p>Address: 1429 Netus Rd, NY 48247</p>
                    <p>Email: Example@gmail.com</p>
                    <p>Phone: +0123 4567 8910</p>
                    <p>Payment Accepted</p>
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
</style>


</body>

</html>