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

        return $result ? $result : false;
    }

    // Insert user and handle supplier insertion if applicable
    function insertUserbo($username, $email, $password, $type, $boid = null) {
        // Sanitize inputs to prevent SQL injection
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $password = $this->db->real_escape_string($password);
        $type = intval($type);
    
        // Sanitize boid if it's provided (for safety, if it's numeric)
        if ($boid !== null) {
            $boid = intval($boid);  // Ensure it's an integer
        }
    
        // Hash the password before inserting it into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Insert into the user table
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$username', '$email', '$hashedPassword', $type)";
    
        if ($this->db->query($sql) === true) {
            // Get the last inserted user ID
            $user_id = $this->db->getInsertId();
    
            if ($type === 1 && $boid) { // 1 represents supplier
                // Insert the supplier with the provided boid
                $this->insertSupplier($user_id, $boid);
            } else {
                return "Error: Business Owner ID is required for supplier.";
            }
    
            // Refresh the users array
            $this->fillArray();
            
            return "User inserted successfully."; // Return success message
        } else {
            return "ERROR: Could not execute the query. " . $this->db->error; // Return error message
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
            // Get the last inserted user ID
            $user_id = $this->db->getInsertId();
    
            if ($type === 1 && $boid) { // 1 represents supplier
                // Insert the supplier with the provided boid
                $this->insertSupplier($user_id, $boid);
            } else {
                return "Error: Business Owner ID is required for supplier.";
            }
    
            // Refresh the users array
            $this->fillArray();
            
            return "User inserted successfully."; // Return success message
        } else {
            return "ERROR: Could not execute the query. " . $this->db->error; // Return error message
        }
    }
    
    public function signUpBusinessOwner($uname, $email, $password) {
        $dbh = new DatabaseHandler();
        $dbh->begin_transaction();
    
        try {
            // Sanitize inputs
            $uname = $dbh->real_escape_string($uname);
            $email = $dbh->real_escape_string($email);
            $password = $dbh->real_escape_string($password);
            
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Insert user data
            $sql = "INSERT INTO user (username, email, password) VALUES ('$uname', '$email', '$hashedPassword')";
            $result = $dbh->query($sql);
            
            if ($result) {
                $userId = $dbh->getInsertId();
    
                // Insert into bowner table
                $sqlBowner = "INSERT INTO bowner (userid) VALUES ('$userId')";
                $resultBowner = $dbh->query($sqlBowner);
    
                if ($resultBowner) {
                    $dbh->commit();
                    return $userId; 
                } else {
                    $dbh->rollback();
                    throw new Exception("Failed to insert into bowner table");
                }
            } else {
                $dbh->rollback();
                throw new Exception("Failed to insert user data");
            }
        } catch (Exception $e) {
            $dbh->rollback();
            throw $e;
        }
    }

    // Insert into the supplier table
    private function insertSupplier($user_id, $boid) {
        if (empty($user_id) || empty($boid)) {
            echo "Error: User ID and Business Owner ID are required to add a supplier.";
            return;
        }

        // Sanitize inputs
        $user_id = intval($user_id);
        $boid = intval($boid);

        // Insert the user ID and boid into the supplier table
        $sql = "INSERT INTO supplier (userid, boid) VALUES ($user_id, $boid)";

        if ($this->db->query($sql) === true) {
            echo "Supplier inserted successfully with User ID: $user_id and assigned to Business Owner ID: $boid.";
        } else {
            echo "ERROR: Could not insert supplier. " . $this->db->error;
        }
    }

    // Get the Business Owner ID for a user
    public function getBOid($userId) {
        $userId = intval($userId);
        $sql = "SELECT boid FROM bowner WHERE userid = $userId";
        $result = $this->db->query($sql);
    
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['boid']; 
        } else {
            return null; 
        }
    }
    public function getSupplierId($userId) {
        $userId = intval($userId);
        $sql = "SELECT supplierid FROM supplier WHERE userid = $userId";
        $result = $this->db->query($sql);
    
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['supplierid']; 
        } else {
            return null; 
        }
    }
    
    

    // Delete a user by ID
    function deleteUser($id) {
        $sql = "DELETE FROM user WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            echo "User deleted successfully.";
            $this->fillArray(); 
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    // Update an existing user
    function updateUser($id, $username, $email, $password) {
        $id = intval($id);
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $password = $this->db->real_escape_string($password);
        
        $sql = "UPDATE user SET 
                    username = '$username', 
                    email = '$email', 
                    password = '$password'
                WHERE id = $id";
    
        if ($this->db->query($sql) === true) {
            echo "User updated successfully.";
            $this->fillArray(); 
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }
}
?>
