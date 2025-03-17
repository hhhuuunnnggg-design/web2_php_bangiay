<?php
require_once __DIR__ . '/../core/db_connect.php';

class ProductModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Lấy tất cả sản phẩm với phân trang và tìm kiếm nâng cao
    public function getAllProducts($search = '', $price_min = null, $price_max = null, $low_stock = false, $limit = 5, $offset = 0)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC 
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
                WHERE sp.TenSP LIKE '%$search%'";

        if ($price_min !== null) {
            $sql .= " AND sp.DonGia >= ?";
        }
        if ($price_max !== null) {
            $sql .= " AND sp.DonGia <= ?";
        }
        if ($low_stock) {
            $sql .= " AND sp.SoLuong <= 20";
        }

        $sql .= " LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);

        if ($price_min !== null && $price_max !== null) {
            $stmt->bind_param("ddii", $price_min, $price_max, $limit, $offset);
        } elseif ($price_min !== null) {
            $stmt->bind_param("dii", $price_min, $limit, $offset);
        } elseif ($price_max !== null) {
            $stmt->bind_param("dii", $price_max, $limit, $offset);
        } else {
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Đếm tổng số sản phẩm để phân trang
    public function getTotalProducts($search = '', $price_min = null, $price_max = null, $low_stock = false)
    {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total 
                FROM sanpham 
                WHERE TenSP LIKE '%$search%'";

        if ($price_min !== null) {
            $sql .= " AND DonGia >= ?";
        }
        if ($price_max !== null) {
            $sql .= " AND DonGia <= ?";
        }
        if ($low_stock) {
            $sql .= " AND SoLuong <= 20";
        }

        $stmt = $this->conn->prepare($sql);

        if ($price_min !== null && $price_max !== null) {
            $stmt->bind_param("dd", $price_min, $price_max);
        } elseif ($price_min !== null) {
            $stmt->bind_param("d", $price_min);
        } elseif ($price_max !== null) {
            $stmt->bind_param("d", $price_max);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'];
    }

    // Lấy sản phẩm theo ID
    public function getProductById($id)
    {
        $id = $this->conn->real_escape_string($id);
        $sql = "SELECT * FROM sanpham WHERE MaSP = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Thêm sản phẩm và chi tiết sản phẩm
    public function addProduct($data, $sizes = [], $colors = [])
    {
        // Thêm sản phẩm vào bảng sanpham
        $sql = "INSERT INTO sanpham (TenSP, MaDM, MaNCC, SoLuong, MoTa, DonGia, AnhNen) VALUES (?, ?, ?, 0, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siisds", $data['TenSP'], $data['MaDM'], $data['MaNCC'], $data['MoTa'], $data['DonGia'], $data['AnhNen']);
        $stmt->execute();
        $maSP = $this->conn->insert_id; // Lấy MaSP vừa thêm

        // Debug: Kiểm tra MaSP
        error_log("MaSP vừa thêm: " . $maSP);

        // Thêm chi tiết sản phẩm vào bảng chitietsanpham
        if (!empty($sizes) && !empty($colors)) {
            $sqlDetail = "INSERT INTO chitietsanpham (MaSP, MaSize, MaMau, SoLuong) VALUES (?, ?, ?, 0)";
            $stmtDetail = $this->conn->prepare($sqlDetail);
            $count = 0;
            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    $stmtDetail->bind_param("iis", $maSP, $size, $color);
                    if ($stmtDetail->execute()) {
                        $count++;
                    } else {
                        error_log("Lỗi thêm chi tiết: " . $stmtDetail->error);
                    }
                }
            }
            error_log("Số bản ghi thêm vào chitietsanpham: " . $count);
        }

        return true;
    }

    // Cập nhật sản phẩm (không cho sửa SoLuong)
    public function updateProduct($id, $data)
    {
        $sql = "UPDATE sanpham SET TenSP = ?, MaDM = ?, MaNCC = ?, MoTa = ?, DonGia = ?, AnhNen = ? WHERE MaSP = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("siisdsi", $data['TenSP'], $data['MaDM'], $data['MaNCC'], $data['MoTa'], $data['DonGia'], $data['AnhNen'], $id);
        return $stmt->execute();
    }


    // Xóa sản phẩm (kiểm tra SoLuong = 0 trước)
    public function deleteProduct($id)
    {
        $id = $this->conn->real_escape_string($id);

        // Kiểm tra SoLuong của sản phẩm
        $sqlCheck = "SELECT SoLuong FROM sanpham WHERE MaSP = ?";
        $stmtCheck = $this->conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $result = $stmtCheck->get_result()->fetch_assoc();

        if ($result && $result['SoLuong'] == 0) {
            // Xóa các bản ghi liên quan trong chitietsanpham
            $sqlDetail = "DELETE FROM chitietsanpham WHERE MaSP = ?";
            $stmtDetail = $this->conn->prepare($sqlDetail);
            $stmtDetail->bind_param("i", $id);
            $stmtDetail->execute();

            // Sau đó xóa sản phẩm trong sanpham
            $sql = "DELETE FROM sanpham WHERE MaSP = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } else {
            // Nếu SoLuong != 0, không xóa và trả về false
            return false;
        }
    }

    // Lấy danh sách danh mục
    public function getCategories()
    {
        $sql = "SELECT * FROM danhmuc";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách nhà cung cấp
    public function getSuppliers()
    {
        $sql = "SELECT * FROM nhacc";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách size
    public function getSizes()
    {
        $sql = "SELECT * FROM size";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    // Lấy danh sách màu
    public function getColors()
    {
        $sql = "SELECT * FROM mau";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->db->closeConnection();
    }
}
