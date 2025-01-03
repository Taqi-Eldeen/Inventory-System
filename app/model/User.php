<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class User extends Model {
    private $id;
    private $username;
    private $email;
    private $password;
    private $type;

    function __construct($id = "", $username = "", $email = "", $password = "", $type = "") {
        $this->db = $this->connect(); 
        
        if ($id !== "") {
            $this->id = $id;
            $this->readUser($id); 
        } else {
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
            $this->type = $type;
        }
    }

    
    function getID() { return $this->id; }
    function getUsername() { return $this->username; }
    function setUsername($username) { $this->username = $username; }

    function getEmail() { return $this->email; }
    function setEmail($email) { $this->email = $email; }

    function getPassword() { return $this->password; }
    function setPassword($password) { $this->password = $password; }

    function getType() { return $this->type; }
    function setType($type) { $this->type = $type; }

    
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

    
    function insertUser() {
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$this->username', '$this->email', '$this->password', '$this->type')";
        
        return $this->db->query($sql) ? true : false;
    }

    
    function updateUser() {
        $sql = "UPDATE user SET 
                    username = '$this->username', 
                    email = '$this->email', 
                    password = '$this->password', 
                    type = '$this->type'
                WHERE id = " . intval($this->id);

        return $this->db->query($sql) ? true : false;
    }

    
    function deleteUser() {
        $sql = "DELETE FROM user WHERE id = " . intval($this->id);

        return $this->db->query($sql) ? true : false;
    }

    
    static function getAllUsers() {
        $db = (new self())->connect(); 
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
