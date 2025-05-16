<head>
    <style>
        body {
            background-color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            display: grid;
            grid-template-columns: 200px 1fr;
        }

        .menu {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
        }

        .content {
            padding: 20px;
        }

        h1 {
            color: black;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        .action-buttons a,
        .action-buttons button {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            margin-right: 5px;
            border: none;
            cursor: pointer;
        }

        .edit {
            background-color: #28a745;
        }

        .lock {
            background-color: #dc3545;
        }

        .search-form {
            margin-bottom: 20px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination a {
            padding: 5px 10px;
            margin: 0 5px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .pagination a.active {
            background-color: #007bff;
            color: white;
        }

        .add-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }
    </style>
</head>
<h1>Quản lý khách hàng</h1>
<a class="add-button" href="/shoeimportsystem/public/index.php?controller=customer&action=add">Thêm khách hàng mới</a>
<form class="search-form" method="GET" action="/shoeimportsystem/public/index.php">
    <input type="hidden" name="controller" value="customer">
    <input type="hidden" name="action" value="index">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên khách hàng" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
    <button type="submit">Tìm kiếm</button>
</form>
<table>
    <tr>
        <th>Mã KH</th>
        <th>Tên KH</th>
        <th>Email</th>
        <th>SĐT</th>
        <th>Địa chỉ</th>
        <th>Trạng thái</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?php echo $customer['MaKH']; ?></td>
            <td><?php echo $customer['TenKH']; ?></td>
            <td><?php echo $customer['Email']; ?></td>
            <td><?php echo $customer['SDT']; ?></td>
            <td><?php echo $customer['DiaChi']; ?></td>
            <td><?php echo $customer['TrangThai'] == 0 ? 'Hoạt động' : 'Bị khóa'; ?></td>
            <td class="action-buttons">
                <a class="edit" href="/shoeimportsystem/public/index.php?controller=customer&action=edit&id=<?php echo $customer['MaKH']; ?>">Sửa</a>
                <?php if ($customer['TrangThai'] == 0): ?>
                    <button class="lock" onclick="lockCustomer(<?php echo $customer['MaKH']; ?>)">Khóa</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<div class="pagination">
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/shoeimportsystem/public/index.php?controller=customer&action=index&page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>
</div>

<script>
    function lockCustomer(id) {
        if (confirm('Bạn có chắc muốn khóa tài khoản này?')) {
            fetch(`/shoeimportsystem/public/index.php?controller=customer&action=lock&id=${id}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Khóa tài khoản thành công!');
                        location.reload();
                    } else {
                        alert('Lỗi: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra!');
                });
        }
    }
</script>