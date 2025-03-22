<h1>Sửa tình trạng hóa đơn - <?php echo $order['MaHD']; ?></h1>
<ul class="breadcrumb">
    <li>
        <a class="menu-link" href="/shoeimportsystem/public/index.php?controller=order&action=index">
            Quản lý hóa đơn
        </a>
    </li>
</ul>

<form id="editOrderForm">
    <p><strong>Mã hóa đơn:</strong> <?php echo $order['MaHD']; ?></p>
    <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['TenKH']); ?></p>
    <p><strong>Tổng tiền:</strong> <?php echo number_format($order['TongTien'], 0, ',', '.') . ' VNĐ'; ?></p>

    <label>Tình trạng:</label>
    <select name="TinhTrang" required>
        <option value="hoàn thành" <?php echo $order['TinhTrang'] === 'hoàn thành' ? 'selected' : ''; ?>>Hoàn thành</option>
        <option value="Hủy Bỏ" <?php echo $order['TinhTrang'] === 'Hủy Bỏ' ? 'selected' : ''; ?>>Hủy Bỏ</option>
    </select><br>

    <button type="submit">Cập nhật</button>
</form>
<div id="message"></div>

<script>
    document.getElementById('editOrderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let maHD = '<?php echo $order['MaHD']; ?>';

        fetch(`/shoeimportsystem/public/index.php?controller=order&action=edit&id=${encodeURIComponent(maHD)}`, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('message').innerHTML = '<p style="color:green;">Cập nhật thành công!</p>';
                    setTimeout(() => {
                        window.location.href = '/shoeimportsystem/public/index.php?controller=order&action=index';
                    }, 1000);
                } else {
                    document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + data.message + '</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra!</p>';
            });
    });
</script>