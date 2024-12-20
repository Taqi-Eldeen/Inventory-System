<?php
require_once(dirname(__FILE__) . '/../model/Inventories.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class InventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = new Inventories();
        parent::__construct($this->inventoryModel);
    }

    /**
     * This method fetches the inventory for the business owner (boid).
     * If it doesn't exist, it creates a new inventory.
     */
    public function getOrCreateInventory() {
        $boid = $_SESSION['boid'];  // Get the boid from the session
        var_dump($boid);  // Debugging: Check if boid is correct
        if (!empty($boid)) {
            $inventory = $this->inventoryModel->getInventoryByBOID($boid);  // Check if inventory exists for boid
            var_dump($inventory);  // Debugging: Check if inventory is returned correctly
            
            if ($inventory) {
                // If inventory exists, return it
                return [
                    'invid' => $inventory['invid'],
                    'boid' => $inventory['boid']
                ];
            } else {
                // If no inventory exists, create a new one for the specific boid
                $newInventory = $this->inventoryModel->insertInventory($boid);
                var_dump($newInventory);  // Debugging: Check the result of inserting the inventory
                return $newInventory;
            }
        } else {
            return null;
        }
    }
    
    
    

    /**
     * Fetches all inventories.
     */
    public function getInventories() {
        $inventories = $this->inventoryModel->fillArray();
        return json_encode($inventories);
    }

    /**
     * Fetches a specific inventory by its ID.
     */
    public function getInventoryByID($invid) {
        if (!empty($invid)) {
            $inventory = $this->inventoryModel->getInventoryByID($invid);
            if ($inventory) {
                // Return inventory without products
                return json_encode([
                    "invid" => $inventory['invid'],
                    "boid" => $inventory['boid']
                ]);
            } else {
                return json_encode(['success' => false, 'message' => 'Inventory record not found.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Inventory ID is required.']);
        }
    }

    /**
     * Deletes an inventory by its ID.
     */
    public function delete($invid) {
        if (!empty($invid)) {
            $success = $this->inventoryModel->deleteInventory($invid);

            if ($success) {
                echo json_encode(['success' => true, 'message' => 'Inventory deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete inventory.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Inventory ID is required.']);
        }
    }
}
?>
