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
    function insertUser($username, $email, $password, $type) {
        // Sanitize inputs to prevent SQL injection
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $password = $this->db->real_escape_string($password);
        $type = intval($type);
    
        // Hash the password before inserting it into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Insert into the user table
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$username', '$email', '$hashedPassword', $type)";
    
        if ($this->db->query($sql) === true) {
            echo "User inserted successfully.";
            
            // Get the last inserted user ID
            $user_id = $this->db->getInsertId();
    
            // If the user is a supplier, insert into the supplier table
            if ($type === 1) { // 1 represents supplier
                $this->insertSupplier($user_id);
            }
    
            // Refresh the users array
            $this->fillArray();
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }
    
    public function signUpBusinessOwner($uname, $email, $password) {
        // Create an instance of the DatabaseHandler class
        $dbh = new DatabaseHandler();
    
        // Start the transaction
        $dbh->begin_transaction();
    
        try {
            // Sanitize and prepare the SQL query
            $uname = $dbh->real_escape_string($uname);
            $email = $dbh->real_escape_string($email);
            $password = $dbh->real_escape_string($password);
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert user data into the user table
            $sql = "INSERT INTO user (username, email, password) VALUES ('$uname', '$email', '$hashedPassword')";
            $result = $dbh->query($sql);
            
            if ($result) {
                // Get the last inserted user ID
                $userId = $dbh->getInsertId();
    
                // Insert the userId into the bowner table (using 'userid' without underscore)
                $sqlBowner = "INSERT INTO bowner (userid) VALUES ('$userId')";
                $resultBowner = $dbh->query($sqlBowner);
    
                if ($resultBowner) {
                    // If insertion into both tables is successful, commit the transaction
                    $dbh->commit();
                    return $userId;  // Return the new user's ID
                } else {
                    // Rollback if inserting into bowner fails
                    $dbh->rollback();
                    throw new Exception("Failed to insert into bowner table");
                }
            } else {
                // Rollback if inserting into user table fails
                $dbh->rollback();
                throw new Exception("Failed to insert user data");
            }
        } catch (Exception $e) {
            // Rollback the transaction if any exception occurs
            $dbh->rollback();
            throw $e;
        }
    }
    
    

    // Additional methods...


    
// Insert into the supplier table
private function insertSupplier($user_id) {
    if (empty($user_id)) {
        echo "Error: User ID is required to add a supplier.";
        return;
    }

    // Insert the user ID into the supplier table
    $sql = "INSERT INTO supplier (userid) 
            VALUES ($user_id)";

    if ($this->db->query($sql) === true) {
        echo "Supplier inserted successfully with User ID: $user_id.";
    } else {
        echo "ERROR: Could not insert supplier. " . $this->db->error;
    }
}
public function getSupplierId($userId) {
    // Sanitize the user ID to prevent SQL injection
    $userId = intval($userId);

    // Query to get the supplier ID from the supplier table
    $sql = "SELECT supplierid FROM supplier WHERE userid = $userId";
    $result = $this->db->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['supplierid'];  // Return the supplier ID
    } else {
        return null;  // Return null if no supplier found
    }
}
public function getBOid($userId) {
    // Sanitize the user ID to prevent SQL injection
    $userId = intval($userId);

    // Query to get the supplier ID from the supplier table
    $sql = "SELECT boid FROM bowner WHERE userid = $userId";
    $result = $this->db->query($sql);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        return $row['boid'];  // Return the supplier ID
    } else {
        return null;  // Return null if no supplier found
    }
}

// Existing methods...



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
