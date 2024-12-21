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
    public function getOrCreateInventory($boid) {
        if (!empty($boid)) {
            $inventory = $this->inventoryModel->getInventoryByBOID($boid);
            
            if ($inventory) {
                // Fetch products for this inventory
                $products = $this->inventoryModel->getProductsByInventoryID($inventory['invid']);
                return [
                    'invid' => $inventory['invid'],
                    'boid' => $inventory['boid'],
                    'products' => $products
                ];
            } else {
                $newInventory = $this->inventoryModel->insertInventory($boid);
                return $newInventory;
            }
        }
        return null;
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
    public function removeProduct($productId) {
        if (!empty($productId)) {
            $success = $this->inventoryModel->deleteProductByIdInInventory($productId);
    
            if ($success) {
                return json_encode(['success' => true, 'message' => 'Product removed successfully.']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to remove product.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Product ID is required.']);
        }
    }
    public function getInventoryForEmployee($empid) {
        return $this->inventoryModel->getInventoryForEmployee($empid);
    }
    
}
?>
