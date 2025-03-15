<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Trang chủ'; ?></title>
    <link rel="stylesheet" href="/shoeimportsystem/public/css/style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/shoeimportsystem/index.php?controller=home&action=index">Trang chủ</a></li>
                <li><a href="/shoeimportsystem/index.php?controller=product&action=index">Sản phẩm</a></li>
                <li><a href="/shoeimportsystem/index.php?controller=auth&action=login">Đăng nhập</a></li>
            </ul>
        </nav>
    </header>
    <main>