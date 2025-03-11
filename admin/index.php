<?php
require_once '../core/db_connect.php';

$db = new Database();
$conn = $db->getConnection();

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sql = "SELECT sp.*, ms.tenmau, sz.tensize, ncc.tensanpham AS nhacungcap 
        FROM sanpham sp 
        LEFT JOIN mausac ms ON sp.id_mausac = ms.id 
        LEFT JOIN size sz ON sp.size_id = sz.id 
        LEFT JOIN nhacungcap ncc ON sp.manhacungcap = ncc.manhacungcap 
        WHERE sp.tensanpham LIKE '%$search%' AND sp.trangthai = 1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Quản lý sản phẩm</h1>
    <a href="add_product.php">Thêm sản phẩm</a> | 
    <a href="color.php">Quản lý màu sắc</a> | 
    <a href="size.php">Quản lý kích thước</a>

    <form method="GET" action="">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Tìm kiếm sản phẩm">
        <button type="submit">Tìm</button>
    </form>

    <table border="1">
        <tr>
            <th>Mã SP</th>
            <th>Tên SP</th>
            <th>Mô tả</th>
            <th>Giá bán</th>
            <th>Số lượng</th>
            <th>Màu sắc</th>
            <th>Kích thước</th>
            <th>Nhà cung cấp</th>
            <th>Hành động</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['masanpham']; ?></td>
            <td><?php echo $row['tensanpham']; ?></td>
            <td><?php echo $row['mota']; ?></td>
            <td><?php echo number_format($row['giaban'], 2); ?></td>
            <td><?php echo $row['soluongconlai']; ?></td>
            <td><?php echo $row['tenmau']; ?></td>
            <td><?php echo $row['tensize']; ?></td>
            <td><?php echo $row['nhacungcap']; ?></td>
            <td>
                <a href="edit_product.php?id=<?php echo $row['masanpham']; ?>">Sửa</a>
                <a href="delete_product.php?id=<?php echo $row['masanpham']; ?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <?php $db->closeConnection(); ?>
</body>
</html>