<?php
require_once __DIR__ . '/../../models/client/CommentModel.php';

class CommentController
{
    private $db;
    private $commentModel;

    public function __construct($db)
    {
        $this->db = $db;
        $this->commentModel = new CommentModel($this->db);
    }

    public function addComment()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập!']);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_GET['productId'] ?? null;
            $comment = trim($_POST['comment'] ?? '');
            $maKH = $_SESSION['user']['MaKH'];

            if ($productId && $comment && $maKH) {
                $result = $this->commentModel->addComment($productId, $maKH, $comment);
                if ($result) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'success' => true,
                        'MaKH' => $maKH,
                        'TenKH' => $_SESSION['user']['TenKH'],
                        'ThoiGian' => date('Y-m-d H:i:s')
                    ]);
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Không thể thêm đánh giá!']);
                }
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ!']);
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ!']);
        }
        exit;
    }
}
