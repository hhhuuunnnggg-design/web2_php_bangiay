<?php
require_once __DIR__ . '/../../core/db_connect.php';


class CommentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCommentsByProductId($productId) {
        $sql = "SELECT * FROM binhluan WHERE MaSP = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addComment($productId, $customerId, $content) {
        $sql = "INSERT INTO binhluan (MaSP, MaKH, NoiDung, ThoiGian) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iis", $productId, $customerId, $content);
        return $stmt->execute();
    }

    public function getReviewsByProductId($productId) {
        try {
            $stmt = $this->db->prepare("SELECT binhluan.*, khachhang.TenKH FROM binhluan JOIN khachhang ON binhluan.MaKH = khachhang.MaKH WHERE binhluan.MaSP = :productId");
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->execute();
            $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $reviews;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    // Các phương thức khác có thể được thêm vào sau này
}
?>