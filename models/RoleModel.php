<?php
require_once __DIR__ . '/../core/db_connect.php';

class RoleModel {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllRoles($search = '', $limit = 5, $offset = 0) {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT * FROM quyen WHERE Ten LIKE '%$search%' LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getTotalRoles($search = '') {
        $search = $this->conn->real_escape_string($search);
        $sql = "SELECT COUNT(*) as total FROM quyen WHERE Ten LIKE '%$search%'";
        $result = $this->conn->query($sql);
        return $result->fetch_assoc()['total'];
    }

    public function getRoleById($id) {
        $sql = "SELECT * FROM quyen WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function addRole($data) {
        $sql = "INSERT INTO quyen (Ten, MoTa) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $data['Ten'], $data['MoTa']);
        return $stmt->execute();
    }

    public function updateRole($id, $data) {
        $sql = "UPDATE quyen SET Ten = ?, MoTa = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $data['Ten'], $data['MoTa'], $id);
        return $stmt->execute();
    }

    public function deleteRole($id) {
        $sql = "DELETE FROM quyen WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}