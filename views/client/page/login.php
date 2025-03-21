<div class="container mt-5">
    <h2>Đăng nhập</h2>
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