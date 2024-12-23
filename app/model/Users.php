<?php

require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/User.php');

class Users extends Model {
    private $users;

    function __construct() {
        $this->users = [];
        $this->db = $this->connect(); 
        $this->fillArray();
    }

    
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

    
    function getUsers() {
        return $this->users;
    }

    
    function readUsers() {
        $sql = "SELECT * FROM user";
        $result = $this->db->query($sql);

        return $result ? $result : false;
    }

    
    function insertUserbo($username, $email, $password, $type, $boid = null) {
        
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $password = $this->db->real_escape_string($password);
        $type = intval($type);
    
        
        if ($boid !== null) {
            $boid = intval($boid);  
        }
    
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$username', '$email', '$hashedPassword', $type)";
    
        if ($this->db->query($sql) === true) {
            
            $user_id = $this->db->getInsertId();
    
            if ($type === 1 && $boid) { 
                
                $this->insertSupplier($user_id, $boid);
            } elseif ($type === 2 && $boid) { 
                
                $this->insertEmployee($user_id, $boid);
            } else {
                return "Error: Business Owner ID is required for both supplier and employee.";
            }
    
            
            $this->fillArray();
            
            return "User inserted successfully."; 
        } else {
            return "ERROR: Could not execute the query. " . $this->db->error; 
        }
    }
    
    function insertUser($username, $email, $password, $type) {
        
        $username = $this->db->real_escape_string($username);
        $email = $this->db->real_escape_string($email);
        $password = $this->db->real_escape_string($password);
        $type = intval($type);
    
    
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        
        $sql = "INSERT INTO user (username, email, password, type) 
                VALUES ('$username', '$email', '$hashedPassword', $type)";
    
        if ($this->db->query($sql) === true) {
            
            $user_id = $this->db->getInsertId();
    
            if ($type === 1 && $boid) { 
                
                $this->insertSupplier($user_id, $boid);
            } else {
                return "Error: Business Owner ID is required for supplier.";
            }
    
            
            $this->fillArray();
            
            return "User inserted successfully."; 
        } else {
            return "ERROR: Could not execute the query. " . $this->db->error; 
        }
    }
    
    public function signUpBusinessOwner($uname, $email, $password) {
        $dbh = DatabaseHandler::getInstance();
        $dbh->begin_transaction();
    
        try {
            
            $uname = $dbh->real_escape_string($uname);
            $email = $dbh->real_escape_string($email);
            $password = $dbh->real_escape_string($password);
            
            
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            
            $sql = "INSERT INTO user (username, email, password) VALUES ('$uname', '$email', '$hashedPassword')";
            $result = $dbh->query($sql);
            
            if ($result) {
                $userId = $dbh->getInsertId();
    
                
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

    
    private function insertSupplier($user_id, $boid) {
        if (empty($user_id) || empty($boid)) {
            echo "Error: User ID and Business Owner ID are required to add a supplier.";
            return;
        }

        
        $user_id = intval($user_id);
        $boid = intval($boid);

        
        $sql = "INSERT INTO supplier (userid, boid) VALUES ($user_id, $boid)";

        if ($this->db->query($sql) === true) {
            echo "Supplier inserted successfully with User ID: $user_id and assigned to Business Owner ID: $boid.";
        } else {
            echo "ERROR: Could not insert supplier. " . $this->db->error;
        }
    }
    private function insertEmployee($user_id, $boid) {
        if (empty($user_id) || empty($boid)) {
            echo "Error: User ID and Business Owner ID are required to add an employee.";
            return;
        }
    
        
        $user_id = intval($user_id);
        $boid = intval($boid);
    
        
        $sql = "INSERT INTO employee (userid, boid) VALUES ($user_id, $boid)";
    
        if ($this->db->query($sql) === true) {
            echo "Employee inserted successfully with User ID: $user_id and assigned to Business Owner ID: $boid.";
        } else {
            echo "ERROR: Could not insert employee. " . $this->db->error;
        }
    }
    
    
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
    public function getEmployeeId($userId) {
        $userId = intval($userId);
        $sql = "SELECT empid FROM employee WHERE userid = $userId";
        $result = $this->db->query($sql);
    
        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['empid']; 
        } else {
            return null; 
        }
    }
    
    
    

    
    function deleteUser($id) {
        $sql = "DELETE FROM user WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            echo "User deleted successfully.";
            $this->fillArray(); 
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    
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
    
public function getSuppliersByBOid($boid) {
    $boid = intval($boid);
    $sql = "SELECT u.id, u.username, u.email FROM user u
            JOIN supplier s ON u.id = s.userid
            WHERE s.boid = $boid";
    
    $result = $this->db->query($sql);

    $suppliers = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $suppliers[] = $row;
        }
    }

    return $suppliers;
}
public function getEmployeeByBOid($boid) {
    $boid = intval($boid);
    $sql = "SELECT u.id, u.username, u.email FROM user u
            JOIN employee e ON u.id = e.userid
            WHERE e.boid = $boid";
    
    $result = $this->db->query($sql);

    $employees = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }
    }

    return $employees;
}


}
?>
