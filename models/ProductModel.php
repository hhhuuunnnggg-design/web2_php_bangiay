<?php
require_once __DIR__ . '/../core/db_connect.php';

class ProductModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllProducts($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT sp.*, ms.tenmau, sz.tensize, ncc.tensanpham AS nhacungcap 
                FROM sanpham sp 
                LEFT JOIN mausac ms ON sp.id_mausac = ms.id 
                LEFT JOIN size sz ON sp.size_id = sz.id 
                LEFT JOIN nhacungcap ncc ON sp.manhacungcap = ncc.manhacungcap 
                WHERE sp.tensanpham LIKE '%$search%' AND sp.trangthai = 1";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Lỗi SQL: " . $this->conn->error);
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM sanpham WHERE masanpham = '$id' AND trangthai = 1";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc();
    }

    public function addProduct($data) {
        // Kiểm tra masanpham đã tồn tại chưa
        $checkSql = "SELECT masanpham FROM sanpham WHERE masanpham = ?";
        $stmtCheck = $this->conn->prepare($checkSql);
        $stmtCheck->bind_param("s", $data['masanpham']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();
        if ($result->num_rows > 0) {
            die("Mã sản phẩm '" . $data['masanpham'] . "' đã tồn tại!");
        }

        $sql = "INSERT INTO sanpham (masanpham, tensanpham, mota, giaban, soluongconlai, size_id, id_mausac, manhacungcap, anh, trangthai) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssdissss", $data['masanpham'], $data['tensanpham'], $data['mota'], $data['giaban'], 
                         $data['soluongconlai'], $data['size_id'], $data['id_mausac'], $data['manhacungcap'], $data['anh']);
        return $stmt->execute();
    }

    public function updateProduct($id, $data) {
        $sql = "UPDATE sanpham SET tensanpham=?, mota=?, giaban=?, soluongconlai=?, size_id=?, id_mausac=?, manhacungcap=?, anh=? 
                WHERE masanpham=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssdisssss", $data['tensanpham'], $data['mota'], $data['giaban'], $data['soluongconlai'], 
                         $data['size_id'], $data['id_mausac'], $data['manhacungcap'], $data['anh'], $id);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "UPDATE sanpham SET trangthai = 0 WHERE masanpham = '$id'";
        return $this->conn->query($sql);
    }

    public function getColors() {
        $sql = "SELECT * FROM mausac WHERE trangthai = 1";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getSizes() {
        $sql = "SELECT * FROM size WHERE trangthai = 1";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function getSuppliers() {
        $sql = "SELECT * FROM nhacungcap WHERE trangthai = 1";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}