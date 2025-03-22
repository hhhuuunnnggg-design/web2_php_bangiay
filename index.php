<?php
session_start();

// Nếu không có controller và action, chuyển hướng về trang chủ
if (!isset($_GET['controller']) && !isset($_GET['action'])) {
    header("Location: /shoeimportsystem/index.php?controller=home&action=index");
    exit;
}

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'home';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Kết nối cơ sở dữ liệu
try {
    $db = new PDO('mysql:host=localhost;dbname=naruto', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Lỗi kết nối cơ sở dữ liệu: ' . $e->getMessage()]);
    exit;
}

// Ghi log yêu cầu
error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

// Tải controller tương ứng
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
        $controllerInstance = new CartController($db); // Sửa $conn thành $db
        break;
    case 'brand':
        require_once __DIR__ . '/controllers/client/BrandController.php';
        $controllerInstance = new BrandController($db);
        break;    
    default:
        header('Content-Type: application/json');
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['success' => false, 'message' => 'Controller không tồn tại']);
        exit;
}

// Xử lý action
try {
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->$action();
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
