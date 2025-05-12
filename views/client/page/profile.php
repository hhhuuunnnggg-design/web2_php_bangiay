Số điện thoại<?php include __DIR__ . '/../layout/header.php'; ?>
<div class="infor mt-5">
    <h2>Thông tin cá nhân</h2>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="/shoeimportsystem/index.php?controller=auth&action=updateProfile" onsubmit="return validateForm()">
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
            <input type="text" name="sdt" class="form-control" value="<?php echo htmlspecialchars($userInfo['SDT']); ?>" required pattern="[0-9]{9}" title="Số điện thoại phải là 9 chữ số bỏ số 0 ở đầu (nếu có)">
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input type="text" name="diaChi" class="form-control" value="<?php echo htmlspecialchars($userInfo['DiaChi']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu cũ</label>
            <input type="password" name="matKhauCu" id="matKhauCu" class="form-control" placeholder="Nhập mật khẩu cũ" required>
        </div>
        <div class="mb-3">
            <label>Mật khẩu mới</label>
            <input type="password" name="matKhauMoi" id="matKhauMoi" class="form-control" placeholder="Nhập mật khẩu mới" required>
        </div>
        <div class="mb-3">
            <label>Xác nhận mật khẩu mới</label>
            <input type="password" name="matKhauXacNhan" id="matKhauXacNhan" class="form-control" placeholder="Xác nhận mật khẩu mới" required>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
    </form>
</div>

<style>
    body {
        background-color: #f4f7fa;
        font-family: 'Poppins', sans-serif;
    }

    .infor {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        font-weight: 600;
        margin-bottom: 30px;
    }

    .alert {
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-success {
        background-color: #d4f4e2;
        color: #2d7d46;
        border: none;
    }

    .alert-danger {
        background-color: #fce4e4;
        color: #a94442;
        border: none;
    }

    .form-control {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    .mb-3 label {
        font-weight: 500;
        color: #555;
        margin-bottom: 5px;
        display: block;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }
</style>

<script>
    function validateForm() {
        const matKhauCu = document.getElementById('matKhauCu').value;
        const matKhauMoi = document.getElementById('matKhauMoi').value;
        const matKhauXacNhan = document.getElementById('matKhauXacNhan').value;

        if (matKhauMoi !== matKhauXacNhan) {
            alert('Mật khẩu mới và xác nhận mật khẩu không khớp!');
            return false;
        }
        if (matKhauMoi.length < 6) {
            alert('Mật khẩu mới phải có ít nhất 6 ký tự!');
            return false;
        }
        if (matKhauCu === matKhauMoi) {
            alert('Mật khẩu mới không được trùng với mật khẩu cũ!');
            return false;
        }
        return true;
    }
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>