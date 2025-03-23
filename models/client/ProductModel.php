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
                WHERE sp.MaDM = ? 
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
    public function filterProducts($categoryIds = null, $brandIds = null, $minPrice = null, $maxPrice = null)
    {
        $conditions = [];
        $params = [];      
        $types = '';   
    
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
    
        // Lọc theo khoảng giá
        if (!empty($minPrice)) {
            $conditions[] = "sp.DonGia >= ?";
            $params[] = $minPrice;
            $types .= 'i';
        }
        if (!empty($maxPrice)) {
            $conditions[] = "sp.DonGia <= ?";
            $params[] = $maxPrice;
            $types .= 'i';
        }
    
        // Xây dựng query
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(' AND ', $conditions);
        }
    
        $sql = "SELECT sp.*, dm.TenDM, ncc.TenNCC 
                FROM sanpham sp
                LEFT JOIN danhmuc dm ON sp.MaDM = dm.MaDM
                LEFT JOIN nhacc ncc ON sp.MaNCC = ncc.MaNCC
                $whereClause";

        
    
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
        return $products;
    }
    

    
    

}



