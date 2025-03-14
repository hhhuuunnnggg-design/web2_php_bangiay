<?php
require_once __DIR__ . '/../core/db_connect.php';

class RoleDetailModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả chi tiết quyền với phân trang
    public function getAllRoleDetails($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT ct.*, q.Ten AS TenQuyen, dc.tenchucnang AS TenChucNang 
                FROM chitietquyen ct 
                LEFT JOIN quyen q ON ct.manhomquyen = q.id 
                LEFT JOIN danhmucchucnang dc ON ct.chucnang = dc.chucnang 
                WHERE q.Ten LIKE '%$search%' OR dc.tenchucnang LIKE '%$search%' 
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số chi tiết quyền để phân trang
    public function getTotalRoleDetails($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM chitietquyen ct 
                LEFT JOIN quyen q ON ct.manhomquyen = q.id 
                LEFT JOIN danhmucchucnang dc ON ct.chucnang = dc.chucnang 
                WHERE q.Ten LIKE '%$search%' OR dc.tenchucnang LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy chi tiết quyền theo manhomquyen, chucnang, hanhdong
    public function getRoleDetail($manhomquyen, $chucnang, $hanhdong) {
        $sql = "SELECT ct.*, q.Ten AS TenQuyen, dc.tenchucnang AS TenChucNang 
                FROM chitietquyen ct 
                LEFT JOIN quyen q ON ct.manhomquyen = q.id 
                LEFT JOIN danhmucchucnang dc ON ct.chucnang = dc.chucnang 
                WHERE ct.manhomquyen = ? AND ct.chucnang = ? AND ct.hanhdong = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $manhomquyen, $chucnang, $hanhdong);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm chi tiết quyền
    public function addRoleDetail($data) {
        $sql = "INSERT INTO chitietquyen (manhomquyen, chucnang, hanhdong) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $data['manhomquyen'], $data['chucnang'], $data['hanhdong']);
        return $stmt->execute();
    }

    // Cập nhật chi tiết quyền
    public function updateRoleDetail($old_manhomquyen, $old_chucnang, $old_hanhdong, $data) {
        $sql = "UPDATE chitietquyen SET manhomquyen = ?, chucnang = ?, hanhdong = ? 
                WHERE manhomquyen = ? AND chucnang = ? AND hanhdong = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iisiis", $data['manhomquyen'], $data['chucnang'], $data['hanhdong'], 
                          $old_manhomquyen, $old_chucnang, $old_hanhdong);
        return $stmt->execute();
    }

    // Xóa chi tiết quyền
    public function deleteRoleDetail($manhomquyen, $chucnang, $hanhdong) {
        $sql = "DELETE FROM chitietquyen WHERE manhomquyen = ? AND chucnang = ? AND hanhdong = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $manhomquyen, $chucnang, $hanhdong);
        return $stmt->execute();
    }

    // Lấy danh sách vai trò (quyen)
    public function getRoles() {
        $sql = "SELECT * FROM quyen";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách chức năng (danhmucchucnang)
    public function getFunctions() {
        $sql = "SELECT * FROM danhmucchucnang";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}