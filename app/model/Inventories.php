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
 
                $this->inventories[] = $inventory;
            }
        }
    }
    public function getProductById($productId) {
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->db->prepare($query); // Assuming $this->db is a MySQLi instance
        $stmt->bind_param('i', $productId); // Bind the product ID as an integer
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result set
        return $result->fetch_assoc(); // Fetch a single row as an associative array
    }
    
    public function getSupplierEmailById($supplierId) {
        // Get the user ID of the supplier
        $query = "SELECT userid FROM supplier WHERE supplierid = ?";
        $stmt = $this->db->prepare($query); // Assuming $this->db is a MySQLi instance
        $stmt->bind_param('i', $supplierId); // Bind the supplier ID as an integer
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result set
        $supplier = $result->fetch_assoc(); // Fetch the supplier as an associative array
    
        if ($supplier) {
            // Fetch the email from the users table
            $query = "SELECT email FROM user WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $supplier['userid']); // Bind the user ID
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); // Fetch the user as an associative array
            return $user ? $user['email'] : null;
        }
    
        return null; // Return null if no supplier is found
    }
    

    public function getBusinessOwnerEmailByInventoryId($inventoryId) {
        // Get the user ID of the business owner
        $query = "
            SELECT bo.userid 
            FROM inventories AS inv
            JOIN business_owners AS bo ON inv.boid = bo.id
            WHERE inv.invid = ?";
        $stmt = $this->db->prepare($query); // Prepare the query
        $stmt->bind_param('i', $inventoryId); // Bind the inventory ID as an integer
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result set
        $businessOwner = $result->fetch_assoc(); // Fetch the business owner as an associative array
    
        if ($businessOwner) {
            // Fetch the email from the users table
            $query = "SELECT email FROM user WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $businessOwner['userid']); // Bind the user ID
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); // Fetch the user as an associative array
            return $user ? $user['email'] : null;
        }
    
        return null; // Return null if no business owner is found
    }
    

   

    public function insertProduct($productDetails) {
        $query = "INSERT INTO products (name, price, qty, supplierid, invid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            $productDetails['name'],
            $productDetails['price'],
            $productDetails['qty'],
            $productDetails['supplierid'],
            $productDetails['invid']
        ]);
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
