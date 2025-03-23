<h1><?php echo $title; ?></h1>
<div id="message"></div>

<form id="assignShipperForm" method="POST">
    <div>
        <label for="MaNVGH">Chọn Shipper:</label>
        <select name="MaNVGH" id="MaNVGH" required>
            <option value="">-- Chọn Shipper --</option>
            <?php foreach ($shippers as $shipper): ?>
                <option value="<?php echo $shipper['MaNV']; ?>">
                    <?php echo htmlspecialchars($shipper['TenNV']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit">Gán Shipper</button>
</form>

<script>
    document.getElementById('assignShipperForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageDiv = document.getElementById('message');
                messageDiv.innerHTML = data.message;
                messageDiv.style.color = data.success ? 'green' : 'red';
                if (data.success) {
                    setTimeout(() => {
                        window.location.href = '/shoeimportsystem/public/index.php?controller=order&action=index';
                    }, 1000);
                }
            })
            .catch(error => {
                document.getElementById('message').innerHTML = 'Lỗi: ' + error;
                document.getElementById('message').style.color = 'red';
            });
    });
</script>