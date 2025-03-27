<?php
require_once __DIR__ . '/../../core/db_connect.php';

class ProductModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }



    // Lấy sản phẩm theo danh mục với thông tin khuyến mãi
    // (giao dien ma co gia khuyen mai la nho cai nay)
    public function getProductsByCategory($categoryId, $limit = 5, $offset = 0)
    {
        $categoryId = $this->conn->real_escape_string($categoryId);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC, 
                   km.KM_PT, km.TienKM, km.NgayBD, km.NgayKT
            FROM sanpham sp 
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
            LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
            LEFT JOIN sanphamkhuyenmai spkm ON sp.MaSP = spkm.MaSP
            LEFT JOIN khuyenmai km ON spkm.MaKM = km.MaKM
            WHERE sp.MaDM = ? AND sp.SoLuong > 1 
            LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $categoryId, $limit, $offset);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        foreach ($products as &$product) {
            $promotion = $this->calculatePromotionPrice(
                $product['DonGia'],
                $product['KM_PT'],
                $product['TienKM'],
                $product['NgayBD'],
                $product['NgayKT']
            );
            $product['GiaKhuyenMai'] = $promotion['price'];
            $product['GiamGia'] = $promotion['discount'];
        }
        unset($product);

        return $products;
    }

    public function searchProductsByName($searchQuery)
    {
        $searchQuery = $this->conn->real_escape_string($searchQuery);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC, 
                       km.KM_PT, km.TienKM, km.NgayBD, km.NgayKT
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
                LEFT JOIN sanphamkhuyenmai spkm ON sp.MaSP = spkm.MaSP
                LEFT JOIN khuyenmai km ON spkm.MaKM = km.MaKM
                WHERE sp.TenSP LIKE ? AND sp.SoLuong > 1";
        $stmt = $this->conn->prepare($sql);
        $searchParam = "%$searchQuery%"; // Thêm % để tìm kiếm gần đúng
        $stmt->bind_param("s", $searchParam);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // Tính giá khuyến mãi cho từng sản phẩm
        foreach ($products as &$product) {
            $promotion = $this->calculatePromotionPrice(
                $product['DonGia'],
                $product['KM_PT'],
                $product['TienKM'],
                $product['NgayBD'],
                $product['NgayKT']
            );
            $product['GiaKhuyenMai'] = $promotion['price'];
            $product['GiamGia'] = $promotion['discount'];
        }
        unset($product);

        return $products;
    }

    // Lấy chi tiết sản phẩm theo MaSP
    public function getProductById($maSP)
    {
        $maSP = $this->conn->real_escape_string($maSP);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC, 
                       km.KM_PT, km.TienKM, km.NgayBD, km.NgayKT
                FROM sanpham sp 
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM 
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC 
                LEFT JOIN sanphamkhuyenmai spkm ON sp.MaSP = spkm.MaSP
                LEFT JOIN khuyenmai km ON spkm.MaKM = km.MaKM
                WHERE sp.MaSP = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maSP);
        $stmt->execute();
        $product = $stmt->get_result()->fetch_assoc();

        if ($product) {
            $promotion = $this->calculatePromotionPrice(
                $product['DonGia'],
                $product['KM_PT'],
                $product['TienKM'],
                $product['NgayBD'],
                $product['NgayKT']
            );
            $product['GiaKhuyenMai'] = $promotion['price'];
            $product['GiamGia'] = $promotion['discount'];
        }

        return $product;
    }

    // Lấy chi tiết kích thước và màu sắc theo MaSP
    public function getProductDetails($maSP)
    {
        $maSP = $this->conn->real_escape_string($maSP);
        $sql = "SELECT MaSize, MaMau FROM chitietsanpham WHERE MaSP = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $maSP);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Tính giá khuyến mãi và mức giảm
    private function calculatePromotionPrice($originalPrice, $kmPT, $tienKM, $ngayBD, $ngayKT)
    {
        $currentDate = date('Y-m-d');
        if (!$ngayBD || !$ngayKT || $currentDate < $ngayBD || $currentDate > $ngayKT) {
            return ['price' => $originalPrice, 'discount' => 0];
        }

        $discountedPrice = $originalPrice;
        $discount = 0;
        if ($kmPT && $kmPT > 0) {
            $discount = $originalPrice * $kmPT / 100;
            $discountedPrice = $originalPrice - $discount;
        } elseif ($tienKM && $tienKM > 0) {
            $discount = $tienKM;
            $discountedPrice = $originalPrice - $tienKM;
        }

        return [
            'price' => max($discountedPrice, 0),
            'discount' => $discount
        ];
    }

    public function getProductsByBrand($brand_id)
    {
        $brand_id = $this->conn->real_escape_string($brand_id);
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC
                FROM sanpham sp
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC
                WHERE sp.MaNCC = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $brand_id);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $products;
    }
    public function filterProducts($categoryIds = null, $brandIds = null, $minPrice = null, $maxPrice = null, $limit = 30, $offset = 0)
    {
        $conditions = [];
        $params = [];
        $types = '';

        // Lấy thông tin khuyến mãi trong truy vấn
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC, 
                   km.KM_PT, km.TienKM, km.NgayBD, km.NgayKT
            FROM sanpham sp
            LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
            LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC
            LEFT JOIN sanphamkhuyenmai spkm ON sp.MaSP = spkm.MaSP
            LEFT JOIN khuyenmai km ON spkm.MaKM = km.MaKM";

        // Lọc theo danh mục
        if (!empty($categoryIds)) {
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $conditions[] = "sp.MaDM IN ($placeholders)";
            foreach ($categoryIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }

        // Lọc theo nhà cung cấp
        if (!empty($brandIds)) {
            $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
            $conditions[] = "sp.MaNCC IN ($placeholders)";
            foreach ($brandIds as $id) {
                $params[] = $id;
                $types .= 'i';
            }
        }

        // Xây dựng giá thực tế để lọc (giá khuyến mãi nếu có, nếu không thì dùng DonGia)
        if ($minPrice !== null || $maxPrice !== null) {
            $conditions[] = "(
            CASE 
                WHEN km.NgayBD <= CURDATE() AND km.NgayKT >= CURDATE() 
                     AND (km.KM_PT > 0 OR km.TienKM > 0)
                THEN 
                    CASE 
                        WHEN km.KM_PT > 0 THEN sp.DonGia * (1 - km.KM_PT / 100)
                        WHEN km.TienKM > 0 THEN sp.DonGia - km.TienKM
                        ELSE sp.DonGia
                    END
                ELSE sp.DonGia
            END
            BETWEEN ? AND ?
        )";
            $params[] = $minPrice ?? 0;
            $params[] = $maxPrice ?? PHP_INT_MAX;
            $types .= 'ii';
        }

        // Xây dựng query
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = " WHERE " . implode(' AND ', $conditions);
        }

        $sql .= "$whereClause LIMIT ? OFFSET ?";
        $params[] = $limit;
        $params[] = $offset;
        $types .= 'ii';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        // Tính giá khuyến mãi cho từng sản phẩm để hiển thị
        foreach ($products as &$product) {
            $promotion = $this->calculatePromotionPrice(
                $product['DonGia'],
                $product['KM_PT'],
                $product['TienKM'],
                $product['NgayBD'],
                $product['NgayKT']
            );
            $product['GiaKhuyenMai'] = $promotion['price'];
            $product['GiamGia'] = $promotion['discount'];
        }
        unset($product);

        return $products;
    }
}
