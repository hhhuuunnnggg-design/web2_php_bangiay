<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?? 'Quản lý Admin'; ?></title>
    <link rel="stylesheet" href="/shoeimportsystem/views/admin/style.css">
</head>
<body>
    <div class="container">
        <!-- Chèn sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Nội dung chính -->
        <div class="content">
            <?php 
            if (isset($content_file)) {
                include $content_file;
            } else {
                echo "<h1>Chào mừng đến với Admin</h1>";
            }
            ?>
        </div>
    </div>
</body>
</html>