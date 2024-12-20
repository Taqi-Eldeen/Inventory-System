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
}
?>
