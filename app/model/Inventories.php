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

    
    public function fillArray() {
        $this->inventories = [];
        $result = $this->readInventories();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                
                $inventory = new Inventory($row["invid"], $row["boid"]);
                
                $this->inventories[] = $inventory;
            }
        }
    }
    public function getProductById($productId) {
        $query = "SELECT * FROM product WHERE id = ?";
        $stmt = $this->db->prepare($query); 
        $stmt->bind_param('i', $productId); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        return $result->fetch_assoc(); 
    }
    
    public function getSupplierEmailById($supplierId) {
        
        $query = "SELECT userid FROM supplier WHERE supplierid = ?";
        $stmt = $this->db->prepare($query); 
        $stmt->bind_param('i', $supplierId); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $supplier = $result->fetch_assoc(); 
    
        if ($supplier) {
            
            $query = "SELECT email FROM user WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $supplier['userid']); 
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 
            return $user ? $user['email'] : null;
        }
    
        return null; 
    }
    public function getBownerEmailById($invid) {
        
        $query = "SELECT boid FROM inventory WHERE invid = ?";
        $stmt = $this->db->prepare($query); 
        $stmt->bind_param('i', $invid); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $inventory = $result->fetch_assoc(); 
    
        if ($inventory) {
            $boid = $inventory['boid']; 
            
            
            $query = "SELECT userid FROM bowner WHERE boid = ?";
            $stmt = $this->db->prepare($query); 
            $stmt->bind_param('i', $boid); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 
            $owner = $result->fetch_assoc(); 
    
            if ($owner) {
                
                $query = "SELECT email FROM user WHERE id = ?";
                $stmt = $this->db->prepare($query); 
                $stmt->bind_param('i', $owner['userid']); 
                $stmt->execute(); 
                $result = $stmt->get_result(); 
                $user = $result->fetch_assoc(); 
                return $user ? $user['email'] : null; 
            }
        }
        
        return null; 
    }
    
    

    public function getBusinessOwnerEmailByInventoryId($inventoryId) {
        
        $query = "
            SELECT bo.userid 
            FROM inventories AS inv
            JOIN business_owners AS bo ON inv.boid = bo.id
            WHERE inv.invid = ?";
        $stmt = $this->db->prepare($query); 
        $stmt->bind_param('i', $inventoryId); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $businessOwner = $result->fetch_assoc(); 
    
        if ($businessOwner) {
            
            $query = "SELECT email FROM user WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $businessOwner['userid']); 
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc(); 
            return $user ? $user['email'] : null;
        }
    
        return null; 
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


    
    public function insertInventory($boid) {
        $sql = "INSERT INTO inventory (boid) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid);
        
        if ($stmt->execute()) {
            
            $invid = $stmt->insert_id;  
            var_dump($invid);  
            return [
                'invid' => $invid,
                'boid' => $boid
            ];
        } else {
            var_dump($stmt->error);  
            return false;
        }
    }
    
    
    

    
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
