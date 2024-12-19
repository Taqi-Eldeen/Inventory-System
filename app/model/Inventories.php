<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/Inventory.php');

class Inventories extends Model {
    private $inventories;

    public function __construct() {
        $this->inventories = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray(); // Populate the array with inventory data when the object is instantiated
    }

    // Populate the inventories array
    public function fillArray() {
        $this->inventories = []; // Clear the current array
        $result = $this->readInventories(); // Fetch data from the database

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $inventory = new Inventory(
                    $row["invid"], 
                    $row["boid"], 
                    $row["productid"], 
                    $row["level"]
                );
                $this->inventories[] = $inventory; // Add each inventory object to the array
            }
        }
    }

    // Return the inventories array
    public function getInventories() {
        return $this->inventories;
    }

    // Fetch all inventories from the database
    private function readInventories() {
        $sql = "SELECT * FROM inventory";
        $result = $this->db->query($sql);

        return ($result && $result->num_rows > 0) ? $result : false;
    }

    // Insert a new inventory record
    public function insertInventory($boid, $productid = null, $level = null) {
        // Prepare the SQL query
        $sql = "INSERT INTO inventory (boid, productid, level) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iii", $boid, $productid, $level); // Bind the parameters

        // Execute the query and refresh the inventory array after insertion
        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the inventories array after insert
            return true;
        } else {
            return false;
        }
    }

    // Delete an inventory record by ID
    public function deleteInventory($invid) {
        $sql = "DELETE FROM inventory WHERE invid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $invid);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the inventories array after delete
            return true;
        } else {
            return false;
        }
    }

    // Update an existing inventory record
    public function updateInventory($invid, $boid, $productid, $level) {
        $sql = "UPDATE inventory SET boid = ?, productid = ?, level = ? WHERE invid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiii", $boid, $productid, $level, $invid);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the inventories array after update
            return true;
        } else {
            return false;
        }
    }

    // Fetch all inventory records in the database
    public static function SelectAllInventoriesInDB() {
        $db = new DatabaseHandler();
        $sql = "SELECT * FROM inventory";
        return $db->query($sql);
    }

    // Fetch inventories by BOID
    public static function SelectInventoriesByBOID($boid) {
        $db = new DatabaseHandler();
        $sql = "SELECT * FROM inventory WHERE boid = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            $inventories = [];
            while ($row = $result->fetch_assoc()) {
                $inventories[] = $row; // Add each inventory to the array
            }
            return $inventories;
        } else {
            return ['success' => false, 'message' => 'No inventory records found for this BOID.'];
        }
    }
}
?>
