<?php
require_once __DIR__ . '/../core/db_connect.php';

class SupplierModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllSuppliers($page = 1, $limit = 5) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM nhacungcap WHERE trangthai = 1 LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalSuppliers() {
        $sql = "SELECT COUNT(*) as total FROM nhacungcap WHERE trangthai = 1";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function addSupplier($tennhacungcap, $diachi) {
        // Tạo mã NCC ngẫu nhiên (NCC + 3 ký tự số)
        $manhacungcap = 'NCC' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    
        // Kiểm tra trùng lặp (trong trường hợp trùng thì tạo lại)
        while ($this->checkDuplicateId($manhacungcap)) {
            $manhacungcap = 'NCC' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        }
    
        $sql = "INSERT INTO nhacungcap (manhacungcap, tennhacungcap, diachi, trangthai) VALUES (?, ?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $manhacungcap, $tennhacungcap, $diachi);
        if ($stmt->execute()) {
            return $manhacungcap;
        }
        return false;
    }
    
    // Kiểm tra trùng lặp ID
    private function checkDuplicateId($manhacungcap) {
        $sql = "SELECT manhacungcap FROM nhacungcap WHERE manhacungcap = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $manhacungcap);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }
    

    public function updateSupplier($manhacungcap, $tennhacungcap, $diachi) {
        $sql = "UPDATE nhacungcap SET tennhacungcap = ?, diachi = ? WHERE manhacungcap = ? AND trangthai = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $tennhacungcap, $diachi, $manhacungcap);
        return $stmt->execute();
    }

    public function deleteSupplier($manhacungcap) {
        $sql = "UPDATE nhacungcap SET trangthai = 0 WHERE manhacungcap = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $manhacungcap);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}