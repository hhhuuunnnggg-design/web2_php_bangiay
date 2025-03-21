<?php
session_start();

if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    header("Location: /shoeimportsystem/index.php?controller=home&action=index");
    exit;
}

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
    case 'auth':
        require_once __DIR__ . '/controllers/client/AuthController.php';
        $controller = new AuthController($db);
        break;
    case 'comment':
        require_once __DIR__ . '/controllers/client/CommentController.php';
        $controller = new CommentController($db);
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
    case 'login':
        $controller->login();
        break;
    case 'doLogin':
        $controller->doLogin();
        break;
    case 'register':
        $controller->register();
        break;
    case 'doRegister':
        $controller->doRegister();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'addComment':
        $controller->addComment();
        break;
    case 'profile':
        $controller->profile();
        break;
    case 'updateProfile':
        $controller->updateProfile();
        break;
    default:
        die("Action không tồn tại");
}
