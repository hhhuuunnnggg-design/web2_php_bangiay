<?php
require_once __DIR__ . '/../models/SizeModel.php';

class SizeController {
    private $sizeModel;

    public function __construct() {
        $this->sizeModel = new SizeModel();
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_size'])) {
            $this->sizeModel->addSize($_POST['tensize']);
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_size'])) {
            $this->sizeModel->updateSize($_POST['id'], $_POST['tensize']);
        } elseif (isset($_GET['delete'])) {
            $this->sizeModel->deleteSize($_GET['delete']);
        }
        $sizes = $this->sizeModel->getAllSizes();
        require_once __DIR__ . '/../views/admin/size_index.php';
    }
}