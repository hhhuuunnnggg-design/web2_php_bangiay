<?php
require_once __DIR__ . '/../core/db_connect.php';

class EmployeeModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllEmployees($search = '', $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT nv.*, q.Ten AS TenQuyen FROM nhanvien nv 
                LEFT JOIN quyen q ON nv.Quyen = q.id 
                WHERE nv.TenNV LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalEmployees($search = '')
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM nhanvien WHERE TenNV LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getEmployeeById($id)
    {
        $sql = "SELECT * FROM nhanvien WHERE MaNV = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addEmployee($data)
    {
        $sql = "INSERT INTO nhanvien (TenNV, Email, SDT, DiaChi, MatKhau, Quyen) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissi", $data['TenNV'], $data['Email'], $data['SDT'], $data['DiaChi'], $data['MatKhau'], $data['Quyen']);
        return $stmt->execute();
    }

    public function updateEmployee($id, $data)
    {
        $sql = "UPDATE nhanvien SET TenNV = ?, Email = ?, SDT = ?, DiaChi = ?, MatKhau = ?, Quyen = ? WHERE MaNV = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssissii", $data['TenNV'], $data['Email'], $data['SDT'], $data['DiaChi'], $data['MatKhau'], $data['Quyen'], $id);
        return $stmt->execute();
    }

    public function deleteEmployee($id)
    {
        $sql = "DELETE FROM nhanvien WHERE MaNV = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getRoles()
    {
        $sql = "SELECT * FROM quyen";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function importEmployee($data)
    {
        $sqlCheck = "SELECT MaNV FROM nhanvien WHERE MaNV = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $data['MaNV']);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result();

        if ($result->num_rows > 0) {
            // Update nếu MaNV đã tồn tại
            $sql = "UPDATE nhanvien SET TenNV = ?, Email = ?, SDT = ?, DiaChi = ?, MatKhau = ?, Quyen = ? WHERE MaNV = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssissii", $data['TenNV'], $data['Email'], $data['SDT'], $data['DiaChi'], $data['MatKhau'], $data['Quyen'], $data['MaNV']);
            return $stmt->execute();
        } else {
            // Insert nếu MaNV chưa tồn tại
            $sql = "INSERT INTO nhanvien (MaNV, TenNV, Email, SDT, DiaChi, MatKhau, Quyen) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ississi", $data['MaNV'], $data['TenNV'], $data['Email'], $data['SDT'], $data['DiaChi'], $data['MatKhau'], $data['Quyen']);
            return $stmt->execute();
        }
    }

    public function getRoleNameById($roleId)
    {
        $sql = "SELECT Ten FROM quyen WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['Ten'] : 'Không xác định';
    }
}
