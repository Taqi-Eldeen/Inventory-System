<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class User extends Model {
    private $id;
    private $username;
    private $email;
    private $password;
    private $type;

    function __construct($id = "", $username = "", $email = "", $password = "", $type = "") {
        $this->db = $this->connect(); // Initialize DB connection
        
        if ($id !== "") {
            $this->id = $id;
            $this->readUser($id); // Fetch user data if ID is provided
        } else {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->type = $type;
        }
    }

    // Getters and Setters
    function getID() { return $this->id; }
    function getUsername() { return $this->username; }
    function setUsername($username) { $this->username = $username; }

    function getEmail() { return $this->email; }
    function setEmail($email) { $this->email = $email; }

    function getPassword() { return $this->password; }
    function setPassword($password) { $this->password = $password; }

    function getType() { return $this->type; }
    function setType($type) { $this->type = $type; }

    // Read user details
    function readUser($id) {
        $sql = "SELECT * FROM user WHERE id = " . intval($id);
        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->username = $row["username"];
            $this->email = $row["email"];
            $this->password = $row["password"];
            $this->type = $row["type"];
        } else {
            $this->username = "";
            $this->email = "";
            $this->password = "";
            $this->type = "";
        }
    }

    // Insert user into the database
    function insertUser() {
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$this->username', '$this->email', '$this->password', '$this->type')";
        
        return $this->db->query($sql) ? true : false;
    }

    // Update user in the database
    function updateUser() {
        $sql = "UPDATE user SET 
                    username = '$this->username', 
                    email = '$this->email', 
                    password = '$this->password', 
                    type = '$this->type'
                WHERE id = " . intval($this->id);

        return $this->db->query($sql) ? true : false;
    }

    // Delete user
    function deleteUser() {
        $sql = "DELETE FROM user WHERE id = " . intval($this->id);

        return $this->db->query($sql) ? true : false;
    }

    // Static method to retrieve all users
    static function getAllUsers() {
        $db = (new self())->connect(); // Create a temporary instance for DB connection
        $sql = "SELECT * FROM user";
        $result = $db->query($sql);

        $users = [];
        while ($row = $result->fetch_assoc()) {
            $user = new self($row["id"], $row["username"], $row["email"], $row["password"], $row["type"]);
            $users[] = $user;
        }
        return $users;
    }
}
?>
