<?php
require_once __DIR__ . '/../../core/db_connect.php';

class CommentModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db; // $db là đối tượng PDO từ index.php
    }

    // Lấy tất cả bình luận theo MaSP (không join với khachhang)
    public function getCommentsByProductId($productId)
    {
        try {
            $sql = "SELECT * FROM binhluan WHERE MaSP = ? ORDER BY ThoiGian DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([(int)$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy bình luận: " . $e->getMessage());
            return [];
        }
    }

    // Thêm bình luận mới
    public function addComment($productId, $customerId, $content)
    {
        try {
            $sql = "INSERT INTO binhluan (MaSP, MaKH, NoiDung, ThoiGian) VALUES (?, ?, ?, NOW())";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([(int)$productId, (int)$customerId, $content]);
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm bình luận: " . $e->getMessage());
            return false;
        }
    }

    // Lấy đánh giá theo MaSP (join với khachhang để lấy TenKH)
    public function getReviewsByProductId($productId)
    {
        try {
            $sql = "SELECT binhluan.*, khachhang.TenKH 
                    FROM binhluan 
                    JOIN khachhang ON binhluan.MaKH = khachhang.MaKH 
                    WHERE binhluan.MaSP = ? 
                    ORDER BY binhluan.ThoiGian DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([(int)$productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy đánh giá: " . $e->getMessage());
            return [];
        }
    }
}
