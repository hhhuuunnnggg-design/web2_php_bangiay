<?php
require_once __DIR__ . '/../core/db_connect.php';

class ImportModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả phiếu nhập với phân trang
    public function getAllImports($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT pn.*, nv.TenNV, sp.TenSP 
                FROM phieunhap pn 
                JOIN nhanvien nv ON pn.MaNV = nv.MaNV 
                JOIN sanpham sp ON pn.MaSP = sp.MaSP 
                WHERE sp.TenSP LIKE '%$search%' 
                LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số phiếu nhập để phân trang
    public function getTotalImports($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM phieunhap pn 
                JOIN sanpham sp ON pn.MaSP = sp.MaSP 
                WHERE sp.TenSP LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    // Lấy phiếu nhập theo ID
    public function getImportById($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM phieunhap WHERE MaPN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm phiếu nhập và cập nhật số lượng
    public function addImport($data) {
        // Thêm phiếu nhập
        $sql = "INSERT INTO phieunhap (MaNV, MaSP, SoLuong, DonGia, TongTien, NgayNhap, Note, Size, Mau) 
                VALUES (?, ?, ?, ?, ?, NOW(), ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiidssis", $data['MaNV'], $data['MaSP'], $data['SoLuong'], $data['DonGia'], 
                          $data['TongTien'], $data['Note'], $data['Size'], $data['Mau']);
        $result = $stmt->execute();

        if ($result) {
            // Cập nhật SoLuong trong chitietsanpham
            $sqlUpdateDetail = "UPDATE chitietsanpham 
                               SET SoLuong = SoLuong + ? 
                               WHERE MaSP = ? AND MaSize = ? AND MaMau = ?";
            $stmtUpdateDetail = $this->conn->prepare($sqlUpdateDetail);
            $stmtUpdateDetail->bind_param("iiis", $data['SoLuong'], $data['MaSP'], $data['Size'], $data['Mau']);
            $stmtUpdateDetail->execute();

            // Cập nhật SoLuong tổng trong sanpham
            $sqlUpdateProduct = "UPDATE sanpham 
                                SET SoLuong = (SELECT SUM(SoLuong) FROM chitietsanpham WHERE MaSP = ?) 
                                WHERE MaSP = ?";
            $stmtUpdateProduct = $this->conn->prepare($sqlUpdateProduct);
            $stmtUpdateProduct->bind_param("ii", $data['MaSP'], $data['MaSP']);
            $stmtUpdateProduct->execute();
        }

        return $result;
    }

    // Cập nhật phiếu nhập
    public function updateImport($id, $data) {
        $sql = "UPDATE phieunhap SET MaNV = ?, MaSP = ?, SoLuong = ?, DonGia = ?, TongTien = ?, Note = ?, Size = ?, Mau = ? WHERE MaPN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iiidssisi", $data['MaNV'], $data['MaSP'], $data['SoLuong'], $data['DonGia'], 
                          $data['TongTien'], $data['Note'], $data['Size'], $data['Mau'], $id);
        return $stmt->execute();
    }

    // Xóa phiếu nhập
    public function deleteImport($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "DELETE FROM phieunhap WHERE MaPN = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}