<?php
require_once __DIR__ . '/../core/db_connect.php';

class SizeModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllSizes() {
        $sql = "SELECT * FROM size WHERE trangthai = 1";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function addSize($tensize) {
        $id = 'S' . substr(uniqid(), -9);
        $sql = "INSERT INTO size (id, tensize, trangthai) VALUES (?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $tensize);
        return $stmt->execute();
    }

    public function updateSize($id, $tensize) {
        $sql = "UPDATE size SET tensize=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $tensize, $id);
        return $stmt->execute();
    }

    public function deleteSize($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "UPDATE size SET trangthai = 0 WHERE id = '$id'";
        return $this->conn->query($sql);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}