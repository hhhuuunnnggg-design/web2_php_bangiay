<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home'; // Mặc định là home
$action = isset($_GET['action']) ? $_GET['action'] : 'index'; // Mặc định là index
$db = new PDO('mysql:host=localhost;dbname=naruto', 'root', '');


error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

switch ($controller) {
    case 'home':
        require_once __DIR__ . '/controllers/client/HomeController.php';
        $controller = new HomeController($db);
        break;
    case 'contact': // Thêm case cho contact
        require_once __DIR__ . '/controllers/client/ContactController.php';
        $controller = new ContactController();
        break; 
    case 'shopdetail':
        require_once __DIR__ . '/controllers/client/ShopdetailController.php';
        $controller = new ShopdetailController();
        break;       
    default:
        die("Controller không tồn tại");
}

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'detail': // Thêm case cho action 'detail'
        $controller->detail();
        break;
    default:
        die("Action không tồn tại");
}