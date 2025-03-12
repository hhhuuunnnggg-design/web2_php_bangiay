<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'product';
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

// Debug: Ghi log yêu cầu để kiểm tra
error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

switch ($controller) {
    case 'product':
        require_once __DIR__ . '/../controllers/ProductController.php';
        $controller = new ProductController();
        break;
    case 'color':
        require_once __DIR__ . '/../controllers/ColorController.php';
        $controller = new ColorController();
        break;
    case 'size':
        require_once __DIR__ . '/../controllers/SizeController.php';
        $controller = new SizeController();
        break;
    case 'supplier':
        require_once __DIR__ . '/../controllers/SupplierController.php';
        $controller = new SupplierController();
        break;
    default:
        die("Controller không tồn tại");
}

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'add':
        $controller->add();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    default:
        die("Action không tồn tại");
}