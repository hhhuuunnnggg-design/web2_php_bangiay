<div class="container form-container mt-5">
    <div class="container mt-5">
        <h2>Đăng ký</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="/shoeimportsystem/index.php?controller=auth&action=doRegister">
            <div class="mb-3">
                <label>Họ tên</label>
                <input type="text" name="tenKH" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Địa chỉ</label>
                <input type="text" name="diaChi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="matKhau" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Đăng ký</button>
            <p>Đã có tài khoản? <a href="/shoeimportsystem/index.php?controller=auth&action=login">Đăng nhập</a></p>
        </form>
    </div>
</div>



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
    .form-container {
        width: 450px;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin: 50px auto;
        text-align: center;
    }

    .form-container h2 {
        color: #333;
        margin-bottom: 20px;
    }

    .form-container .alert {
        font-size: 14px;
    }

    .form-container label {
        font-weight: bold;
        color: #555;
        text-align: left;
        display: block;
    }

    .form-container input {
        width: 100%;
        border-radius: 5px;
        padding: 8px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
    }

    .form-container button {
        background: #0072ff;
        border: none;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        border-radius: 5px;
        transition: 0.3s;
    }

    .form-container button:hover {
        background: #005ecb;
    }

    .form-container p {
        margin-top: 15px;
    }

    .form-container p a {
        color: #0072ff;
        text-decoration: none;
        font-weight: bold;
    }

    .form-container p a:hover {
        text-decoration: underline;
    }
</style>
