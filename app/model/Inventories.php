<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/inventory.php');

class Inventories extends Model {
    private $inventories;

    public function __construct() {
        $this->inventories = [];
        $this->db = $this->connect();
        $this->fillArray();
    }

    // Method to read all inventories from the database
    public function readInventories() {
        $sql = "SELECT * FROM inventory";
        $result = $this->db->query($sql);
        return $result;
    }

    // Method to fetch all inventories
    public function fillArray() {
        $this->inventories = [];
        $result = $this->readInventories();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Create Inventory object
                $inventory = new Inventory($row["invid"], $row["boid"]);
                // Add the inventory to the inventories array
                $this->inventories[] = $inventory;
            }
        }
    }

    // Method to insert inventory for a business owner (boid)
    public function insertInventory($boid) {
        $sql = "INSERT INTO inventory (boid) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid);
        
        if ($stmt->execute()) {
            // Log or print the result to ensure insertion is successful
            $invid = $stmt->insert_id;  // Get the inserted ID
            var_dump($invid);  // Debugging: Check the inserted inventory ID
            return [
                'invid' => $invid,
                'boid' => $boid
            ];
        } else {
            var_dump($stmt->error);  // Debugging: Check the error in case of failure
            return false;
        }
    }
    
    
    

    // Method to delete an inventory by its ID
    public function deleteInventory($invid) {
        $sql = "DELETE FROM inventory WHERE invid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $invid);

        if ($stmt->execute()) {
            $this->fillArray();
            return true;
        } else {
            return false;
        }
    }

    // Method to check if inventory exists for a specific boid
    public function getInventoryByBOID($boid) {
        $sql = "SELECT * FROM inventory WHERE boid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0 ? $result->fetch_assoc() : null;
    }
    public function getProductsByInventoryID($invid) {
        $sql = "SELECT p.id AS product_id, p.name AS product_name, p.price, p.qty, s.userid AS supplier_name 
                FROM product p
                JOIN supplier s ON p.supplierid = s.supplierid
                WHERE p.invid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $invid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    
        return $products;
    }
    
    public function deleteProductByIdInInventory($productId) {
        $sql = "DELETE FROM product WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $productId);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getInventoryForEmployee($employeeid) {
        // Step 1: Fetch boid (Business Owner ID) based on employeeid
        $getBoidSql = "SELECT boid FROM employee WHERE empid = ?";
        $stmt = $this->db->prepare($getBoidSql);
        $stmt->bind_param("i", $employeeid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Step 2: If no employee found, return an error message
        if ($result->num_rows === 0) {
            echo "ERROR: No employee found with Employee ID $employeeid.";
            return false;
        }
    
        // Fetch the boid from the result
        $row = $result->fetch_assoc();
        $boid = $row['boid'];
    
        // Step 3: Fetch invid (Inventory ID) for the business owner (boid)
        $getInvidSql = "SELECT invid FROM inventory WHERE boid = ?";
        $stmt = $this->db->prepare($getInvidSql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Step 4: If no inventory found for the business owner, return an error
        if ($result->num_rows === 0) {
            echo "ERROR: No inventory found for Business Owner ID $boid.";
            return false;
        }
    
        // Fetch the invid
        $row = $result->fetch_assoc();
        $invid = $row['invid'];
    
        // Return the invid (Inventory ID) associated with the employee's business owner
        return $invid;
    }
    
    
}
?>
