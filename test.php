<!DOCTYPE html>
<html lang="en">

<head>
    <title>Classic Login Form Responsive Widget Template :: w3layouts</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta
        name="keywords"
        content="Classic Login Form Responsive Widget,Login form widgets, Sign up Web forms , Login signup Responsive web form,Flat Pricing table,Flat Drop downs,Registration Forms,News letter Forms,Elements" />
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
    <!-- Style-CSS -->
    <link rel="stylesheet" href="/shoeimportsystem/views/client/page/auth/css/font-awesome.css" />
    <!-- Font-Awesome-Icons-CSS -->
    <!-- //css files -->

    <!-- js -->
    <script type="text/javascript" src="/shoeimportsystem/views/client/page/auth/js/jquery-2.1.4.min.js"></script>
    <!-- //js -->

    <!-- online-fonts -->
    <link
        href="//fonts.googleapis.com/css?family=Oleo+Script:400,700&amp;subset=latin-ext"
        rel="stylesheet" />
    <!-- //online-fonts -->
</head>

<body>
    <script src="/shoeimportsystem/views/client/page/auth/js/jquery.vide.min.js"></script>
    <div class="container form-container mt-5">
        <div class="container mt-5">
            <h2>Đăng nhập888</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <form method="POST" action="/shoeimportsystem/index.php?controller=auth&action=doLogin">
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Mật khẩu</label>
                    <input type="password" name="matKhau" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                <p>Chưa có tài khoản? <a href="/shoeimportsystem/index.php?controller=auth&action=register">Đăng ký</a></p>
            </form>
        </div>
    </div>
    <!-- -------------- -->
    <div data-vide-bg="/shoeimportsystem/views/client/page/auth/video/Ipad">
        <?php
        session_start();

        // Xử lý khi form được submit
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['Name'] ?? '';
            $password = $_POST['Password'] ?? '';

            // Kết nối database (giả sử dùng MySQLi)
            $conn = new mysqli("localhost", "root", "", "ten_csdl");
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Chuẩn bị câu truy vấn để chống SQL Injection
            $stmt = $conn->prepare("SELECT id, email, mat_khau FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            // Kiểm tra kết quả
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['mat_khau'])) {
                    // Đăng nhập thành công
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: dashboard.php"); // Chuyển hướng sau khi login
                    exit;
                } else {
                    $error = "Mật khẩu không đúng.";
                }
            } else {
                $error = "Email không tồn tại.";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <div class="center-container">
            <!--header-->
            <div class="header-w3l">
                <h1>Classic Login Form</h1>
            </div>
            <!--//header-->

            <div class="main-content-agile">
                <div class="sub-main-w3">
                    <div class="wthree-pro">
                        <h2>Login Here</h2>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div style="color: red; margin-bottom: 10px;"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form action="" method="post">
                        <input
                            placeholder="Username or E-mail"
                            name="Name"
                            class="user"
                            type="email"
                            required />
                        <span class="icon1"><i class="fa fa-user" aria-hidden="true"></i></span><br /><br />

                        <input
                            placeholder="Password"
                            name="Password"
                            class="pass"
                            type="password"
                            required />
                        <span class="icon2"><i class="fa fa-unlock" aria-hidden="true"></i></span><br />

                        <div class="sub-w3l">
                            <h6><a href="#">Forgot Password?</a></h6>
                            <div class="right-w3l">
                                <input type="submit" value="Login" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--//main-->

            <!--footer-->
            <div class="footer">
                <p>
                    &copy; 2017 Classic Login Form. All rights reserved | Design by
                    <a href="http://w3layouts.com">W3layouts</a>
                </p>
            </div>
            <!--//footer-->
        </div>

    </div>
</body>

</html>