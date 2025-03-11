<?php
require_once __DIR__ . '/../config/config.php';

class Database {
    private $conn;

    // public function __construct() {
    //     $this->conn = new mysqli(HOST_NAME, DB_USER, DB_PASSWORD, DB_NAME);
    //     if ($this->conn->connect_error) {
    //         die("Kết nối thất bại: " . $this->conn->connect_error);
    //     } else {
    //         echo "Kết nối thành công!";
    //         exit;
    //     }
    //     $this->conn->set_charset("utf8mb4");
    // }

    public function __construct() {
        $this->conn = new mysqli(HOST_NAME, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}