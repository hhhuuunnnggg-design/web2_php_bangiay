<h1>Thống kê 5 khách hàng mua nhiều nhất</h1>
<div style="display: flex; justify-content: space-between;">
    <form id="statsForm" method="POST">
        <label>Ngày bắt đầu:</label>
        <input type="date" name="start_date" required>
        <label>Ngày kết thúc:</label>
        <input type="date" name="end_date" required>
        <button type="submit">Thống kê</button>
    </form>
</div>

<div id="message"></div>

<table border="1" id="statsTable" style="display:none;">
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã KH</th>
            <th>Tên KH</th>
            <th>Email</th>
            <th>Tổng mua</th>
            <th>Hóa đơn</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
    document.getElementById('statsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const startDate = new Date(formData.get('start_date'));
        const endDate = new Date(formData.get('end_date'));

        if (startDate > endDate) {
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: Ngày bắt đầu phải bé hơn ngày kết thúc!</p>';
            return;
        }

        fetch('/shoeimportsystem/public/index.php?controller=statistics&action=topCustomers', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.querySelector('#statsTable tbody');
                    tbody.innerHTML = '';
                    data.data.forEach((customer, index) => {
                        const tr = document.createElement('tr');
                        let ordersHtml = '<ul>';
                        customer.Orders.forEach(order => {
                            ordersHtml += `
                        <li>
                            ${order.MaHD} - ${order.NgayDat} - ${order.ThanhTienDonHang}
                            <button onclick="viewOrderDetails('${order.MaHD}')">Xem chi tiết</button>
                            <div id="details-${order.MaHD}" style="display:none;"></div>
                        </li>
                    `;
                        });
                        ordersHtml += '</ul>';

                        tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${customer.MaKH}</td>
                    <td>${customer.TenKH}</td>
                    <td>${customer.Email}</td>
                    <td>${customer.TongMua}</td>
                    <td>${ordersHtml}</td>
                `;
                        tbody.appendChild(tr);
                    });
                    document.getElementById('statsTable').style.display = 'table';
                    document.getElementById('message').innerHTML = '<p style="color:green;">Thống kê thành công!</p>';
                } else {
                    document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: Không có dữ liệu!</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
            });
    });

    function viewOrderDetails(maHD) {
        const detailDiv = document.getElementById(`details-${maHD}`);
        if (!detailDiv) {
            console.error(`Không tìm thấy phần tử với ID: details-${maHD}`);
            document.getElementById('message').innerHTML = '<p style="color:red;">Lỗi: Không tìm thấy chi tiết hóa đơn!</p>';
            return;
        }

        // Nếu đang hiển thị thì ẩn đi, nếu ẩn thì lấy dữ liệu và hiển thị
        if (detailDiv.style.display === 'block') {
            detailDiv.style.display = 'none';
        } else {
            fetch(`/shoeimportsystem/public/index.php?controller=statistics&action=orderDetails&id=${maHD}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        detailDiv.innerHTML = `
                    <table border="1" style="width:100%; margin-top:10px;">
                        <thead>
                            <tr>
                                <th>Mã SP</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                                <th>Size</th>
                                <th>Màu</th>
                                <th>Ảnh</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${data.data.map(item => `
                                <tr>
                                    <td>${item.MaSP}</td>
                                    <td>${item.SoLuong}</td>
                                    <td>${item.DonGia}</td>
                                    <td>${item.ThanhTienSanPham}</td>
                                    <td>${item.Size}</td>
                                    <td>${item.MaMau}</td>
                                    <td>
                                        ${item.img ? `<img src="${item.img}" alt="Hình ảnh sản phẩm" style="max-width: 100px; height: auto;">` : 'Không có hình ảnh'}
                                    </td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                `;
                        detailDiv.style.display = 'block';
                    } else {
                        detailDiv.innerHTML = '<p style="color:red;">Không có chi tiết cho hóa đơn này!</p>';
                        detailDiv.style.display = 'block';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    detailDiv.innerHTML = '<p style="color:red;">Có lỗi xảy ra: ' + error.message + '</p>';
                    detailDiv.style.display = 'block';
                });
        }
    }
</script>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    button {
        cursor: pointer;
        margin-left: 10px;
    }
</style>