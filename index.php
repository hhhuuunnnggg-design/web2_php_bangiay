<?php
session_start();

if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    header("Location: /shoeimportsystem/index.php?controller=home&action=index");
    exit;
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

try {
    $db = new PDO('mysql:host=localhost;dbname=naruto', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage()]);
    exit;
}

error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

switch ($controller) {
    case 'home':
        require_once __DIR__ . '/controllers/client/HomeController.php';
        $controllerInstance = new HomeController($db);
        break;
    case 'contact':
        require_once __DIR__ . '/controllers/client/ContactController.php';
        $controllerInstance = new ContactController();
        break;
    case 'shopdetail':
        require_once __DIR__ . '/controllers/client/ShopdetailController.php';
        $controllerInstance = new ShopdetailController();
        break;
    case 'auth':
        require_once __DIR__ . '/controllers/client/AuthController.php';
        $controllerInstance = new AuthController($db);
        break;
    case 'comment':
        require_once __DIR__ . '/controllers/client/CommentController.php';
        $controllerInstance = new CommentController($db);
        break;
    case 'cart':
        require_once __DIR__ . '/controllers/client/CartController.php';
        $controllerInstance = new CartController($db);
        break;
    case 'brand':
        require_once __DIR__ . '/controllers/client/BrandController.php';
        $controllerInstance = new BrandController($db);
        break;
    case 'shop':
        require_once __DIR__ . '/controllers/client/ShopController.php';
        $controllerInstance = new ShopController($db);
        break;
    case 'orderhistory': // Thêm case cho OrderHistoryController
        require_once __DIR__ . '/controllers/client/OrderHistoryController.php';
        $controllerInstance = new OrderHistoryController($db);
        break;
    case 'checkout': // Thêm case cho CheckoutController
        require_once __DIR__ . '/controllers/client/CheckoutController.php';
        $controllerInstance = new CheckoutController($db);
        break;
    default:
        header('Content-Type: application/json');
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['success' => false, 'message' => 'Controller không tồn tại']);
        exit;
}

try {
    if (method_exists($controllerInstance, $action)) {
        switch ($action) {
            case 'addToCart':
            case 'removeFromCart':
                $controllerInstance->$action();
                exit; // Dừng sau khi xử lý AJAX
            case 'index':
            case 'detail':
            case 'canceled': // Thêm case cho canceled
            case 'shipping': // Thêm case cho shipping
                $controllerInstance->$action();
                break;
            default:
                $controllerInstance->$action();
        }
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => "Action không tồn tại"]);
        exit;
    }
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Lỗi server: ' . $e->getMessage()]);
    exit;
}
