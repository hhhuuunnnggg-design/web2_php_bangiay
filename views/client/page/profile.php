<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="container mt-5">
    <h2>Thông tin cá nhân</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="/shoeimportsystem/index.php?controller=auth&action=updateProfile">
        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="tenKH" class="form-control" value="<?php echo htmlspecialchars($userInfo['TenKH']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($userInfo['Email']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="sdt" class="form-control" value="<?php echo htmlspecialchars($userInfo['SDT']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="diaChi" class="form-control" value="<?php echo htmlspecialchars($userInfo['DiaChi']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="matKhau" class="form-control" value="<?php echo htmlspecialchars($userInfo['MatKhau']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>
<?php include __DIR__ . '/../layout/footer.php'; ?>