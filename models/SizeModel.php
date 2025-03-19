<?php
require_once __DIR__ . '/../core/db_connect.php';

class SizeModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả kích thước với phân trang
    public function getAllSizes($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM size WHERE MaSize LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số kích thước để tính phân trang
    public function getTotalSizes($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM size WHERE MaSize LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy kích thước theo MaSize
    public function getSizeById($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM size WHERE MaSize = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm kích thước
    public function addSize($data)
    {
        $sql = "INSERT INTO size (MaSize) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $data['MaSize']);
        return $stmt->execute();
    }

    // Cập nhật kích thước
    public function updateSize($id, $data)
    {
        $sql = "UPDATE size SET MaSize = ? WHERE MaSize = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $data['MaSize'], $id);
        return $stmt->execute();
    }

    // Xóa kích thước
    public function deleteSize($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM size WHERE MaSize = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function importSize($data)
    {

        $sqlCheck = "SELECT MaSize FROM size ";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $data['MaSize']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Update nếu MaSize đã tồn tại
            $sql = "UPDATE size SET MaSize = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $data['MaSize']);
            $stmt->execute();
        } else {
            // Insert nếu MaSize chưa tồn tại
            $sql = "INSERT INTO size (MaSize) VALUES (?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $data['MaSize']);
            $stmt->execute();
        }
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
