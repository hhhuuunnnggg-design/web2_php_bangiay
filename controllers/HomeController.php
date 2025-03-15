<?php
class HomeController {
    public function index() {
        $title = "Trang chủ";
        include __DIR__ . '/../views/client/home.php';
    }
}