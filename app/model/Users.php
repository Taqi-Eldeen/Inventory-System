<?php
// Include the Model and User class files using relative paths
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/User.php');

class Users extends Model {
    private $users;

    function __construct() {
        $this->users = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray();
    }

    // Populate the users array
    function fillArray() {
        $this->users = [];
        $result = $this->readUsers();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $user = new User(
                    $row["id"], 
                    $row["username"], 
                    $row["email"], 
                    $row["password"], 
                    $row["type"]
                );
                array_push($this->users, $user);
            }
        }
    }

    // Return the users array
    function getUsers() {
        return $this->users;
    }

    // Fetch all users from the database
    function readUsers() {
        $sql = "SELECT * FROM user";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Insert a new user into the database
    function insertUser($username, $email, $password, $type) {
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$username', '$email', '$password', '$type')";

        if ($this->db->query($sql) === true) {
            echo "User inserted successfully.";
            $this->fillArray(); // Refresh the users array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    // Delete a user by ID
    function deleteUser($id) {
        $sql = "DELETE FROM user WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            echo "User deleted successfully.";
            $this->fillArray(); // Refresh the users array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    // Update an existing user
    function updateUser($id, $username, $email, $password) {
        // Sanitize the inputs to avoid SQL injection
        $id = intval($id);
        $username = $this->db->real_escape_string($username);  // Sanitize username
        $email = $this->db->real_escape_string($email);        // Sanitize email
        $password = $this->db->real_escape_string($password);  // Sanitize password
        
        // Prepare the SQL query to update the user
        $sql = "UPDATE user SET 
                    username = '$username', 
                    email = '$email', 
                    password = '$password'
                WHERE id = $id";
    
        // Execute the query and check for success
        if ($this->db->query($sql) === true) {
            echo "User updated successfully.";
            $this->fillArray(); // Refresh the users array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }
    
}
?>
