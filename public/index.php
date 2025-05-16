<?php
$controller = isset($_GET['controller']) ? $_GET['controller'] : 'auth';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';

error_log("Request: controller=$controller, action=$action, method=" . $_SERVER['REQUEST_METHOD']);

switch ($controller) {
    case 'category':
        require_once __DIR__ . '/../controllers/CategoryController.php';
        $controller = new CategoryController();
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
    case 'employee':
        require_once __DIR__ . '/../controllers/EmployeeController.php';
        $controller = new EmployeeController();
        break;
    case 'role':
        require_once __DIR__ . '/../controllers/RoleController.php';
        $controller = new RoleController();
        break;
    case 'role_detail':
        require_once __DIR__ . '/../controllers/RoleDetailController.php';
        $controller = new RoleDetailController();
        break;
    case 'function':
        require_once __DIR__ . '/../controllers/FunctionController.php';
        $controller = new FunctionController();
        break;
    case 'promotion':
        require_once __DIR__ . '/../controllers/PromotionController.php';
        $controller = new PromotionController();
        break;
    case 'product':
        require_once __DIR__ . '/../controllers/ProductController.php';
        $controller = new ProductController();
        break;
    case 'product_detail':
        require_once __DIR__ . '/../controllers/ProductDetailController.php';
        $controller = new ProductDetailController();
        break;
    case 'product_promotion':
        require_once __DIR__ . '/../controllers/ProductPromotionController.php';
        $controller = new ProductPromotionController();
        break;
    case 'import':
        require_once __DIR__ . '/../controllers/ImportController.php';
        $controller = new ImportController();
        break;
    case 'auth':
        require_once __DIR__ . '/../controllers/AuthController.php';
        $controller = new AuthController();
        break;
    case 'order':
        require_once __DIR__ . '/../controllers/OrderController.php';
        $controller = new OrderController();
        break;

    case 'statistics':
        require_once __DIR__ . '/../controllers/StatisticsController.php';
        $controller = new StatisticsController();
        break;

    case 'customer':
        require_once __DIR__ . '/../controllers/CustomerController.php';
        $controller = new CustomerController();
        break;
    case 'lock':
        if ($controller instanceof CustomerController) {
            $controller->lock();
        } else {
            die("Action không hợp lệ cho controller này");
        }
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
    case 'login':
        $controller->login();
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'import':
        $controller->import();
        break;
    case 'export':
        $controller->export();
        break;
    case 'detail':
        $controller->detail();
        break;
    case 'assignShipper':
        if ($controller instanceof OrderController) {
            $controller->assignShipper();
        } else {
            die("Action không hợp lệ cho controller này");
        }
        break;

    case 'topCustomers':
        if ($controller instanceof StatisticsController) {
            $controller->topCustomers();
        } else {
            die("Action không hợp lệ cho controller này");
        }
        break;
    case 'orderDetails':
        if ($controller instanceof StatisticsController) {
            $controller->orderDetails();
        } else {
            die("Action không hợp lệ cho controller này");
        }
        break;
    default:
        die("Action không tồn tại");
}
