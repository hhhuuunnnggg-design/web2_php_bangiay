<?php
require_once __DIR__ . '/../models/ColorModel.php';

class ColorController {
    private $colorModel;

    public function __construct() {
        $this->colorModel = new ColorModel();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_color'])) {
            $this->colorModel->addColor($_POST['tenmau']);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_color'])) {
            $this->colorModel->updateColor($_POST['id'], $_POST['tenmau']);
        } elseif (isset($_GET['delete'])) {
            $this->colorModel->deleteColor($_GET['delete']);
        }
        $colors = $this->colorModel->getAllColors();
        $title = "Quản lý màu sắc";
        $content_file = __DIR__ . '/../views/admin/color_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php'; // Sử dụng layout mới
    }
}