<?php
// Include necessary models and the base Controller
require_once(dirname(__FILE__) . '/../model/Inventories.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class InventoryController extends Controller {
    private $inventoryModel; // Instance of the Inventories class

    public function __construct() {
        $this->inventoryModel = new Inventories(); // Initialize the Inventories model
        parent::__construct($this->inventoryModel); // Pass the model to the parent constructor
    }

    // Insert a product into the inventory
    public function insert() {
        $boid = $_SESSION['boid']; // Retrieve boid from session

        // Temporarily set productid and level to null
        $productid = null;
        $level = null;

        // Check if boid is available
        if (!empty($boid)) {
            try {
                // Call the model method to insert the inventory record with null values for now
                $success = $this->inventoryModel->insertInventory($boid, $productid, $level);
                
                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Inventory created successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to create inventory.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
            }
        } else {
            // Return an error message if boid is not provided
            echo json_encode(['success' => false, 'message' => 'Branch Office ID (boid) is required.']);
        }
    }

    // Other methods can remain unchanged, such as getInventories(), getInventoryByID(), delete(), edit(), etc.


    

    // Get all inventory records
    public function getInventories() {
        // Fetch all inventory records using the Inventories model
        $inventories = $this->inventoryModel->fillArray();
        return json_encode($inventories); // Return inventory data as JSON
    }

    // Get inventory details by ID
    public function getInventoryByID($invid) {
        if (!empty($invid)) {
            // Fetch inventory details using the model method
            $inventory = $this->inventoryModel->getInventoryByID($invid);
            if ($inventory) {
                return json_encode([
                    "invid" => $inventory['invid'],
                    "boid" => $inventory['boid'],
                    "productid" => $inventory['productid'],
                    "level" => $inventory['level']
                ]);
            } else {
                // Return an error message if inventory record is not found
                return json_encode(['success' => false, 'message' => 'Inventory record not found.']);
            }
        } else {
            // Return an error message if Inventory ID is not provided
            return json_encode(['success' => false, 'message' => 'Inventory ID is required to fetch details.']);
        }
    }

    // Delete inventory by ID
    public function delete($invid) {
        if (!empty($invid)) {
            // Call the model method to delete the inventory record
            $success = $this->inventoryModel->deleteInventory($invid);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Inventory deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete inventory.']);
            }
        } else {
            // Return an error message if Inventory ID is not provided
            echo json_encode(['success' => false, 'message' => 'Inventory ID is required to delete a record.']);
        }
    }

    // Edit inventory details
    public function edit() {
        $invid = $_POST['invid']; // Inventory ID
        $boid = $_POST['boid'];   // Branch Office ID
        $productid = $_POST['productid']; // Product ID
        $level = $_POST['level']; // Stock level

        // Check if all fields are provided
        if (!empty($invid) && !empty($boid) && !empty($productid) && !empty($level)) {
            // Call the model method to update the inventory
            $success = $this->inventoryModel->updateInventory($invid, $boid, $productid, $level);
            
            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Inventory updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update inventory.']);
            }
        } else {
            // Return an error message if any required field is empty
            echo json_encode(['success' => false, 'message' => 'All fields are required to edit an inventory record.']);
        }
    }
}
?>
