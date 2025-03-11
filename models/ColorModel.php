<?php
require_once __DIR__ . '/../core/db_connect.php';

class ColorModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllColors() {
        $sql = "SELECT * FROM mausac WHERE trangthai = 1";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }

    public function addColor($tenmau) {
        $id = 'M' . substr(uniqid(), -9);
        $sql = "INSERT INTO mausac (id, tenmau, trangthai) VALUES (?, ?, 1)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $id, $tenmau);
        return $stmt->execute();
    }

    public function updateColor($id, $tenmau) {
        $sql = "UPDATE mausac SET tenmau=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $tenmau, $id);
        return $stmt->execute();
    }

    public function deleteColor($id) {
        $id = $this->conn->real_escape_string($id);
        $sql = "UPDATE mausac SET trangthai = 0 WHERE id = '$id'";
        return $this->conn->query($sql);
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}