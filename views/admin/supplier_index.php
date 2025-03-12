<h1>Quản lý nhà cung cấp</h1>
<form id="addSupplierForm">
    <input type="text" name="tennhacungcap" placeholder="Tên nhà cung cấp" required>
    <input type="text" name="diachi" placeholder="Địa chỉ" required>
    <input type="hidden" name="add_supplier" value="1"> <!-- Thêm trường ẩn -->
    <button type="submit">Thêm</button> <!-- Không cần name="add_supplier" ở đây nữa -->
</form>
<div id="message"></div>

<table border="1" id="supplierTable">
    <thead>
        <tr>
            <th>Mã NCC</th>
            <th>Tên nhà cung cấp</th>
            <th>Địa chỉ</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($suppliers as $row): ?>
        <tr data-id="<?php echo $row['manhacungcap']; ?>">
            <td><?php echo $row['manhacungcap']; ?></td>
            <td><?php echo $row['tennhacungcap']; ?></td>
            <td><?php echo $row['diachi']; ?></td>
            <td>
                <form class="editSupplierForm" style="display:inline;">
                    <input type="hidden" name="manhacungcap" value="<?php echo $row['manhacungcap']; ?>">
                    <input type="text" name="tennhacungcap" value="<?php echo $row['tennhacungcap']; ?>" required>
                    <input type="text" name="diachi" value="<?php echo $row['diachi']; ?>" required>
                    <input type="hidden" name="edit_supplier" value="1"> <!-- Thêm trường ẩn -->
                    <button type="submit" class="btn btn-warning">Sửa</button>
                </form>
                <button class="delete-btn btn btn-danger" data-id="<?php echo $row['manhacungcap']; ?>">Xóa</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="#" class="page-link" data-page="<?php echo $i; ?>" <?php if ($i == $page) echo 'style="font-weight:bold;"'; ?>><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

<script>
// Hàm tải dữ liệu theo trang
function loadSuppliers(page) {
    fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=index&page=${page}`)
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newTbody = doc.querySelector('#supplierTable tbody').innerHTML;
        document.querySelector('#supplierTable tbody').innerHTML = newTbody;
        attachEditDeleteEvents();
    })
    .catch(error => {
        console.error('Error loading page:', error);
        document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi tải dữ liệu!</p>';
    });
}

// Thêm nhà cung cấp
document.getElementById('addSupplierForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/shoeimportsystem/public/index.php?controller=supplier&action=index', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.text(); // Dùng text() để debug nguyên văn phản hồi
    })
    .then(text => {
        console.log('Raw response (add):', text); // Debug phản hồi nguyên văn
        try {
            let data = JSON.parse(text); // Parse thành JSON
            if (data.success) {
                document.getElementById('message').innerHTML = '<p style="color:green;">Thêm nhà cung cấp thành công!</p>';
                this.reset();
                let tbody = document.getElementById('supplierTable').querySelector('tbody');
                let newRow = `<tr data-id="${data.id}">
                    <td>${data.id}</td>
                    <td>${formData.get('tennhacungcap')}</td>
                    <td>${formData.get('diachi')}</td>
                    <td>
                        <form class="editSupplierForm" style="display:inline;">
                            <input type="hidden" name="manhacungcap" value="${data.id}">
                            <input type="text" name="tennhacungcap" value="${formData.get('tennhacungcap')}" required>
                            <input type="text" name="diachi" value="${formData.get('diachi')}" required>
                            <input type="hidden" name="edit_supplier" value="1">
                            <button type="submit" class="btn btn-warning">Sửa</button>
                        </form>
                        <button class="delete-btn btn btn-danger" data-id="${data.id}">Xóa</button>
                    </td>
                </tr>`;
                tbody.insertAdjacentHTML('beforeend', newRow);
                attachEditDeleteEvents();
            } else {
                document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + (data.message || 'Không rõ nguyên nhân') + '</p>';
            }
        } catch (error) {
            console.error('Parse error (add):', error, 'Response:', text);
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi phân tích dữ liệu từ server!</p>';
        }
    })
    .catch(error => {
        console.error('Error (add):', error);
        document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
    });
});

// Sửa và xóa nhà cung cấp
function attachEditDeleteEvents() {
    document.querySelectorAll('.editSupplierForm').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch('/shoeimportsystem/public/index.php?controller=supplier&action=index', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.status);
                }
                return response.text();
            })
            .then(text => {
                console.log('Raw response (edit):', text); // Debug phản hồi nguyên văn
                try {
                    let data = JSON.parse(text);
                    if (data.success) {
                        document.getElementById('message').innerHTML = '<p style="color:green;">Cập nhật thành công!</p>';
                        let row = form.closest('tr');
                        row.querySelector('td:nth-child(2)').textContent = formData.get('tennhacungcap');
                        row.querySelector('td:nth-child(3)').textContent = formData.get('diachi');
                    } else {
                        document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + (data.message || 'Không rõ nguyên nhân') + '</p>';
                    }
                } catch (error) {
                    console.error('Parse error (edit):', error, 'Response:', text);
                    document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi phân tích dữ liệu từ server!</p>';
                }
            })
            .catch(error => {
                console.error('Error (edit):', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
            });
        });
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            if (confirm('Xóa nhà cung cấp này?')) {
                fetch(`/shoeimportsystem/public/index.php?controller=supplier&action=index&delete=${id}`, {
                    method: 'POST'
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response (delete):', text); // Debug phản hồi nguyên văn
                    try {
                        let data = JSON.parse(text);
                        if (data.success) {
                            document.querySelector(`tr[data-id="${id}"]`).remove();
                            document.getElementById('message').innerHTML = '<p style="color:green;">Xóa thành công!</p>';
                        } else {
                            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: ' + (data.message || 'Không rõ nguyên nhân') + '</p>';
                        }
                    } catch (error) {
                        console.error('Parse error (delete):', error, 'Response:', text);
                        document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi phân tích dữ liệu từ server!</p>';
                    }
                })
                .catch(error => {
                    console.error('Error (delete):', error);
                    document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
                });
            }
        });
    });
}

// Phân trang
document.querySelectorAll('.page-link').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const page = this.getAttribute('data-page');
        loadSuppliers(page);
    });
});

// Gắn sự kiện ban đầu
attachEditDeleteEvents();
</script>