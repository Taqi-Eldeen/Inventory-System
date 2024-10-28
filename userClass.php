<?php
include "DBConnection.php";

class Users {
    private $db;

    // Constructor accepts the DB connection as a parameter
    public function __construct($db) {
        $this->db = $db;
    }

    public function createUser($username, $email, $type, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, email, type, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $type, $hashedPassword);
        return $stmt->execute();
    }

    public function readUser($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public function updateUser($id, $username, $email, $type, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, email = ?, type = ?, password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $type, $hashedPassword, $id);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

   // List all users
public function listUsers() {
    $sql = "SELECT * FROM user"; // Corrected table name
    $result = $this->db->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
?>
