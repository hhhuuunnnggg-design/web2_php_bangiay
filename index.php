<?php
session_start(); // Khởi động session
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$db = new PDO('mysql:host=localhost;dbname=naruto', 'root', '');

error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

switch ($controller) {
    case 'home':
        require_once __DIR__ . '/controllers/client/HomeController.php';
        $controller = new HomeController($db);
        break;
    case 'contact':
        require_once __DIR__ . '/controllers/client/ContactController.php';
        $controller = new ContactController();
        break;
    case 'shopdetail':
        require_once __DIR__ . '/controllers/client/ShopdetailController.php';
        $controller = new ShopdetailController();
        break;
    case 'auth': // Thêm case cho auth
        require_once __DIR__ . '/controllers/client/AuthController.php';
        $controller = new AuthController($db);
        break;
    default:
        die("Controller không tồn tại");
}

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'detail':
        $controller->detail();
        break;
    case 'login': // Thêm action login
        $controller->login();
        break;
    case 'doLogin': // Xử lý đăng nhập
        $controller->doLogin();
        break;
    case 'register': // Thêm action register
        $controller->register();
        break;
    case 'doRegister': // Xử lý đăng ký
        $controller->doRegister();
        break;
    case 'logout': // Đăng xuất
        $controller->logout();
        break;
    default:
        die("Action không tồn tại");
}
