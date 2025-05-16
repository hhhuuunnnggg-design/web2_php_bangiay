<?php
require_once __DIR__ . '/../models/CustomerModel.php';

class CustomerController
{
    private $model;

    public function __construct()
    {
        $this->model = new CustomerModel();
    }

    public function index()
    {
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $customers = $this->model->getAllCustomers($search, $limit, $offset);
        $total = $this->model->getTotalCustomers($search);
        $totalPages = ceil($total / $limit);

        require_once __DIR__ . '/../views/admin/customer/customer_index.php';
    }

    public function add()
    {
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
        require_once __DIR__ . '/../views/admin/customer/customer_add.php';
    }

    public function edit()
    {
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
        require_once __DIR__ . '/../views/admin/customer/customer_edit.php';
    }

    public function lock()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $result = $this->model->lockCustomer($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result, 'message' => $result ? 'Khóa tài khoản thành công' : 'Lỗi khi khóa tài khoản']);
        exit;
    }
}
