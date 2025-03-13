<?php
session_start();

require_once __DIR__ . '/db_connect.php';
class Auth {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function login($email, $password) {
        $email = $this->conn->real_escape_string($email);
        $sql = "SELECT * FROM nhanvien WHERE Email = ? AND MatKhau = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    public function checkPermission($function, $action) {
        if (!isset($_SESSION['user'])) {
            return false;
        }
        $quyen = $_SESSION['user']['Quyen'];
        
        if ($quyen == 1) { // Admin full quyền
            return true;
        }

        $sql = "SELECT * FROM chitietquyen WHERE manhomquyen = ? AND chucnang = ? AND hanhdong = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iis", $quyen, $function, $action);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    public function getCurrentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
    }
}