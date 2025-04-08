<?php
require_once __DIR__ . '/../../core/db_connect.php';

class Supplier
{
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'naruto'); // Chỉnh DB nếu cần
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        mysqli_set_charset($this->conn, 'utf8');
    }

    public function getAllBrands()
    {
        $result = $this->conn->query("SELECT * FROM nhacc");
        $brands = [];
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
        return $brands;
    }

    public function getBrandById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM nhacc WHERE MaNCC = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc(); // Trả về null nếu không tìm thấy
    }
}
