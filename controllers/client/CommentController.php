<?php

require_once __DIR__ . '/../../models/client/CommentModel.php';
class CommentController {
    private $commentModel;
    private $db; // Lưu trữ kết nối cơ sở dữ liệu

    public function __construct($db) {
        $this->db = $db;
        $this->commentModel = new CommentModel($db);
    }

    public function addComment($productId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $comment = $_POST['comment'];
                $MaKH = 1; // Giả sử MaKH là 1

                $sql = "INSERT INTO binhluan (MaSP, MaKH, NoiDung) VALUES (:MaSP, :MaKH, :NoiDung)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':MaSP', $productId, PDO::PARAM_INT);
                $stmt->bindParam(':MaKH', $MaKH, PDO::PARAM_INT);
                $stmt->bindParam(':NoiDung', $comment, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    $response = [
                        'success' => true,
                        'MaKH' => $MaKH,
                        'ThoiGian' => date('Y-m-d H:i:s'),
                    ];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                } else {
                    $response = ['success' => false, 'error' => 'Lỗi khi thêm đánh giá vào cơ sở dữ liệu.'];
                    header('Content-Type: application/json');
                    echo json_encode($response);
                }
            } catch (PDOException $e) {
                error_log("Lỗi thêm đánh giá: " . $e->getMessage());
                $response = ['success' => false, 'error' => 'Lỗi server. Vui lòng thử lại sau.'];
                header('Content-Type: application/json');
                echo json_encode($response);
            }
        }
    }

    // Các phương thức khác có thể được thêm vào sau này (ví dụ: xóa bình luận)
}
?>