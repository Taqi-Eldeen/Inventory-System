<?php
include "DBConnection.php";

class Users {
    public $id;
    public $username;
    public $email;
    public $type;
    public $password;
    private $db;

    public function __construct() {
        // Establish a database connection
        $this->db = new DBConnection(); // Assuming DBConnection class handles the connection
    }

    // Create User
    public function createUser($username, $email, $type, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
        $sql = "INSERT INTO users (username, email, type, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $type, $hashedPassword);
        return $stmt->execute();
    }

    // Read User by ID
    public function readUser($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    // Update User
    public function updateUser($id, $username, $email, $type, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
        $sql = "UPDATE users SET username = ?, email = ?, type = ?, password = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $type, $hashedPassword, $id);
        return $stmt->execute();
    }

    // Delete User
    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // List all users
    public function listUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); // Returns an array of all users
    }
}
?>
