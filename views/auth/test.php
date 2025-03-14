<!DOCTYPE HTML>
<html lang="vi">
<head>
    <title>Đăng nhập - Hệ thống nhập khẩu giày</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    
   
    <link rel="stylesheet" href="/shoeimportsystem/public/css/font-awesome.css">
    <script type="text/javascript" src="/shoeimportsystem/public/js/jquery-2.1.4.min.js"></script>
    <link href="//fonts.googleapis.com/css?family=Oleo+Script:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="./css/font-awesome.css" type="text/css" media="all" />
    <link rel="stylesheet" href="./css/style.css" type="text/css" media="all" />
</head>
<body>
    <script src="/shoeimportsystem/public/js/jquery.vide.min.js"></script>
    <div data-vide-bg="/shoeimportsystem/public/video/Ipad">
        <div class="center-container">
            <div class="header-w3l">
                <h1>Hệ thống nhập khẩu giày</h1>
            </div>
            <div class="main-content-agile">
                <div class="sub-main-w3">    
                    <div class="wthree-pro">
                        <h2>Đăng nhập</h2>
                    </div>
                    <?php if (isset($error)): ?>
                        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
                    <?php endif; ?>
                    <form method="POST" action="/shoeimportsystem/public/index.php?controller=auth&action=login">
                        <input placeholder="Email" name="email" class="user" type="email" required>
                        <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span><br><br>
                        <input placeholder="Mật khẩu" name="password" class="pass" type="password" required>
                        <span class="icon2"><i class="fa fa-unlock" aria-hidden="true"></i></span><br>
                        <div class="sub-w3l">
                            <h6><a href="#">Quên mật khẩu?</a></h6>
                            <div class="right-w3l">
                                <input type="submit" value="Đăng nhập">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="footer">
                <p>&copy; 2025 Hệ thống nhập khẩu giày. Thiết kế bởi <a href="#">Nhóm phát triển</a></p>
            </div>
        </div>
    </div>
</body>
</html>