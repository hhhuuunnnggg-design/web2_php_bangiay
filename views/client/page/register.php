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