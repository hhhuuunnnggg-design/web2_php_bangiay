<?php
require_once __DIR__ . '/../models/CustomerModel.php';
require_once __DIR__ . '/../core/Auth.php';

class CustomerController
{
    private $model;
    private $auth;

    public function __construct()
    {
        $this->model = new CustomerModel();
        $this->auth = new Auth();
        if (!$this->auth->getCurrentUser()) {
            header("Location: /shoeimportsystem/public/index.php?controller=auth&action=login");
            exit;
        }
    }

    public function index()
    {
        if (!$this->auth->checkPermission(14, 'view')) {
            die("Bạn không có quyền xem quản lý khách hàng.");
        }
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $customers = $this->model->getAllCustomers($search, $limit, $offset);
        $total = $this->model->getTotalCustomers($search);
        $totalPages = ceil($total / $limit);

        $title = "Quản lý khách hàng";
        $content_file = __DIR__ . '/../views/admin/customer_index.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function add()
    {
        if (!$this->auth->checkPermission(14, 'add')) {
            die("Bạn không có quyền thêm khách hàng.");
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'MaKH' => $_POST['MaKH'],
                'TenKH' => $_POST['TenKH'],
                'Email' => $_POST['Email'],
                'SDT' => $_POST['SDT'],
                'DiaChi' => $_POST['DiaChi'],
                'MatKhau' => $_POST['MatKhau']
            ];

            $result = $this->model->addCustomer($data);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result, 'message' => $result ? 'Thêm khách hàng thành công' : 'Lỗi khi thêm khách hàng']);
            exit;
        }

        $title = "Thêm khách hàng";
        $content_file = __DIR__ . '/../views/admin/customer/customer_add.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function edit()
    {
        if (!$this->auth->checkPermission(14, 'edit')) {
            die("Bạn không có quyền sửa khách hàng.");
        }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'TenKH' => $_POST['TenKH'],
                'Email' => $_POST['Email'],
                'SDT' => $_POST['SDT'],
                'DiaChi' => $_POST['DiaChi'],
                'MatKhau' => $_POST['MatKhau']
            ];

            $result = $this->model->updateCustomer($id, $data);
            header('Content-Type: application/json');
            echo json_encode(['success' => $result, 'message' => $result ? 'Cập nhật thành công' : 'Lỗi khi cập nhật']);
            exit;
        }

        $customer = $this->model->getCustomerById($id);
        if (!$customer) {
            die("Khách hàng không tồn tại");
        }

        $title = "Sửa khách hàng";
        $content_file = __DIR__ . '/../views/admin/customer/customer_edit.php';
        include __DIR__ . '/../views/admin/layout/layout.php';
    }

    public function lock()
    {
        if (!$this->auth->checkPermission(14, 'edit')) {
            echo json_encode(['success' => false, 'message' => 'Bạn không có quyền khóa tài khoản khách hàng']);
            exit;
        }
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $result = $this->model->lockCustomer($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result, 'message' => $result ? 'Khóa tài khoản thành công' : 'Lỗi khi khóa tài khoản']);
        exit;
    }
}
