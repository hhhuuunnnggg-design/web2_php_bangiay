<!--Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html lang="vi">

<head>
    <title><?php echo isset($title) ? $title : 'Đăng ký'; ?></title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Classic Register Form Responsive Widget, Sign up Web forms" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- Meta tag Keywords -->

    <!-- css files -->
    <link rel="stylesheet" href="/shoeimportsystem/views/client/page/auth/css/style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/shoeimportsystem/views/client/page/auth/css/font-awesome.css" />
    <!-- //css files -->

    <!-- js files -->
    <script type="text/javascript" src="/shoeimportsystem/views/client/page/auth/js/jquery-2.1.4.min.js"></script>
    <!-- jQuery phải tải trước vide.js -->

    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Oleo+Script:400,700&subset=latin-ext" rel="stylesheet" />
    <!-- //online-fonts -->
    <style>
        .error-message {
            color: #ff0000;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
            background: rgba(255, 0, 0, 0.1);
            padding: 10px;
            border-radius: 5px;
        }

        .sub-main-w3 input.name,
        .sub-main-w3 input.user,
        .sub-main-w3 input.phone,
        .sub-main-w3 input.address,
        .sub-main-w3 input.pass {
            position: relative;
            padding-right: 40px;
            margin-bottom: 15px;
        }

        span.icon1,
        span.icon2,
        span.icon3,
        span.icon4,
        span.icon5 {
            color: #fff;
            font-size: 1.1em;
            position: absolute;
            right: 5%;
            top: 50%;
            transform: translateY(-50%);
        }

        span.icon1 {
            /* Họ tên */
            top: 14%;
        }

        span.icon2 {
            /* Email */
            top: 30%;
        }

        span.icon3 {
            /* Số điện thoại */
            top: 46%;
        }

        span.icon4 {
            /* Địa chỉ */
            top: 62%;
        }

        span.icon5 {
            /* Mật khẩu */
            top: 78%;
        }

        @media (max-width: 768px) {
            .sub-main-w3 {
                width: 90%;
                margin: 0 auto;
            }

            .header-w3l h1 {
                font-size: 24px;
            }
        }

        .sub-main-w3 input[type="text"] {
            outline: none;
            font-size: 1em;
            padding: 1em 3em 1em 1em;
            border: none;
            margin-bottom: 0.3em;
            background: none;
            border: 1px solid #eee;
            width: 82%;

            font-weight: 400;
            font-family: "Oleo Script", cursive;
            letter-spacing: 1px;
        }



        .sub-main-w3 {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .wthree-pro h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }

        form {
            position: relative;
        }

        .input-group {
            position: relative;
            margin-bottom: 15px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            /* Chừa chỗ cho icon */
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
        }

        .input-group span {
            position: absolute;
            right: 10px;
            /* Đặt icon bên phải */
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        .input-group span i {
            font-size: 16px;
        }
    </style>
</head>

<body>
    <script src="/shoeimportsystem/views/client/page/auth/js/jquery.vide.min.js"></script>
    <!-- main -->
    <div data-vide-bg="/shoeimportsystem/views/client/page/auth/video/Ipad" style="background: url('/shoeimportsystem/views/client/page/auth/images/fallback.jpg') no-repeat center center fixed; background-size: cover;">
        <div class="center-container">
            <!--header-->
            <div class="header-w3l">
                <h1>Đăng ký</h1>
            </div>
            <!--//header-->
            <div class="main-content-agile">
                <div class="sub-main-w3">
                    <div class="wthree-pro">
                        <h2>Đăng ký tài khoản</h2>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form id="registerForm" action="/shoeimportsystem/index.php?controller=auth&action=doRegister" method="post">
                        <div class="input-group">
                            <input style="color: black;" placeholder="Họ tên" name="tenKH" class="name" type="text" required="" />
                            <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        </div>

                        <div class="input-group">
                            <input style="color: black;" placeholder="Email" name="email" class="user" type="email" required="" />
                            <span class="icon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        </div>

                        <div class="input-group">
                            <input style="color: black;" placeholder="Số điện thoại" name="sdt" class="phone" type="text"
                                pattern="[0-9]{10}"
                                title="Vui lòng nhập đúng 10 chữ số"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                required="" />
                            <span class="icon3"><i class="fa fa-phone" aria-hidden="true"></i></span>
                        </div>

                        <div class="input-group">
                            <input placeholder="Địa chỉ" name="diaChi" class="address" type="text" required="" />
                            <span class="icon4"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                        </div>

                        <div class="input-group">
                            <input style="color: black;" placeholder="Mật khẩu" name="matKhau" class="pass" type="password" required="" />
                            <span class="icon5"><i class="fa fa-unlock" aria-hidden="true"></i></span>
                        </div>

                        <div class="sub-w3l">
                            <div class="right-w3l">
                                <input type="submit" value="Đăng ký" />
                            </div>
                            <h6>Đã có tài khoản? <a href="/shoeimportsystem/index.php?controller=auth&action=login">Đăng nhập</a></h6>
                        </div>
                    </form>

                    <script>
                        $(document).ready(function() {
                            $('#registerForm').on('submit', function(e) {
                                e.preventDefault();

                                // Validate form
                                var formData = new FormData(this);
                                var isValid = true;
                                var errorMessage = '';

                                // Validate email format
                                var email = formData.get('email');
                                if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                                    isValid = false;
                                    errorMessage = 'Email không hợp lệ!';
                                }

                                // Validate password length
                                var password = formData.get('matKhau');
                                if (password.length < 6) {
                                    isValid = false;
                                    errorMessage = 'Mật khẩu phải có ít nhất 6 ký tự!';
                                }

                                // Validate phone number
                                var phone = formData.get('sdt');
                                if (!phone.match(/^[0-9]{10}$/)) {
                                    isValid = false;
                                    errorMessage = 'Số điện thoại phải có đúng 10 chữ số!';
                                }

                                if (!isValid) {
                                    $('.error-message').remove();
                                    $('.wthree-pro').after('<div class="error-message">' + errorMessage + '</div>');
                                    return;
                                }

                                // Submit form using AJAX
                                $.ajax({
                                    url: $(this).attr('action'),
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        if (response.success) {
                                            // Redirect to login page on success
                                            window.location.href = '/shoeimportsystem/index.php?controller=auth&action=login';
                                        } else {
                                            // Show error message
                                            $('.error-message').remove();
                                            $('.wthree-pro').after('<div class="error-message">' + response.message + '</div>');
                                        }
                                    },
                                    error: function() {
                                        $('.error-message').remove();
                                        $('.wthree-pro').after('<div class="error-message">Có lỗi xảy ra, vui lòng thử lại!</div>');
                                    }
                                });
                            });
                        });
                    </script>

                </div>
            </div>
            <!--//main-->

            <!--footer-->
            <div class="footer">
                <p>© 2025 Hệ thống nhập giày. All rights reserved | Thiết kế bởi Bạn</p>
            </div>
            <!--//footer-->
        </div>
    </div>
</body>

</html>