<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
            color: #fff;
        }
        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            width: 420px;
            color: #333;
            text-align: center;
            animation: fadeIn 0.5s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ccc;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.5);
        }
        .btn-primary {
            background-color: #667eea;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            transition: all 0.3s ease;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .btn-primary:hover {
            background-color: #764ba2;
            box-shadow: 0 4px 12px rgba(118, 75, 162, 0.5);
            transform: translateY(-2px);
        }
        h2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: rgba(255, 0, 0, 0.1);
            color: #ff0000;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            font-weight: bold;
            display: block;
            text-align: left;
            margin-bottom: 5px;
            color: #555;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Đăng ký</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?controller=auth&action=register">
        <div class="form-group">
            <label>Họ và tên:</label>
            <input type="text" name="tenNV" class="form-control" placeholder="Nhập họ và tên" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" placeholder="Nhập email" required>
        </div>
        <div class="form-group">
            <label>Số điện thoại:</label>
            <input type="text" name="sdt" class="form-control" placeholder="Nhập số điện thoại" required>
        </div>
        <div class="form-group">
            <label>Địa chỉ:</label>
            <input type="text" name="diaChi" class="form-control" placeholder="Nhập địa chỉ" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu:</label>
            <input type="password" name="matKhau" class="form-control" placeholder="Nhập mật khẩu" required>
        </div>
        <div class="form-group">
            <label>Nhập lại mật khẩu:</label>
            <input type="password" name="confirmMatKhau" class="form-control" placeholder="Nhập lại mật khẩu" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
