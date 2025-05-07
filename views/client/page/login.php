<!-- C:\xampp\htdocs\shoeimportsystem\views\client\page\login.php on line 91 -->
<!DOCTYPE html>
<html lang="vi">

<head>
    <title><?php echo isset($title) ? $title : 'Đăng nhập'; ?></title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Classic Login Form Responsive Widget, Login form widgets, Sign up Web forms" />
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, Reynold1);
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

        .icon1,
        .icon2 {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }

        .user,
        .pass {
            position: relative;
            padding-right: 40px;
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
    </style>
</head>

<body>
    <script src="/shoeimportsystem/views/client/page/auth/js/jquery.vide.min.js"></script>
    <!-- main -->
    <div data-vide-bg="/shoeimportsystem/views/client/page/auth/video/Ipad" style="background: url('/shoeimportsystem/views/client/page/auth/images/fallback.jpg') no-repeat center center fixed; background-size: cover;">
        <div class="center-container">
            <!--header-->
            <div class="header-w3l">
                <h1>Đăng nhập</h1>
            </div>
            <!--//header-->
            <div class="main-content-agile">
                <div class="sub-main-w3">
                    <div class="wthree-pro">
                        <h2>Đăng nhập tại đây</h2>
                    </div>
                    <?php if (isset($error)): ?>
                        <div class="error-message"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form action="/shoeimportsystem/index.php?controller=auth&action=doLogin" method="post">
                        <?php

                        if (!isset($_SESSION['csrf_token'])) {
                            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                        }
                        ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <input placeholder="Email" name="email" class="user" type="email" required="" />
                        <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span><br /><br />
                        <input placeholder="Mật khẩu" name="matKhau" class="pass" type="password" required="" />
                        <span class="icon2"><i class="fa fa-unlock" aria-hidden="true"></i></span><br />
                        <div class="sub-w3l">

                            <div class="right-w3l">
                                <input type="submit" value="Đăng nhập" />
                            </div>
                            <h6>Chưa có tài khoản? <a href="/shoeimportsystem/index.php?controller=auth&action=register">Đăng ký</a></h6>
                        </div>
                    </form>
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