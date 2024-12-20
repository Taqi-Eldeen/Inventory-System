<?php
require_once(dirname(__FILE__) . '/../model/Inventories.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class InventoryController extends Controller {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = new Inventories();
        parent::__construct($this->inventoryModel);
    }

    public function insert() {
        $boid = $_SESSION['boid'];

        if (!empty($boid)) {
            try {
                $success = $this->inventoryModel->insertInventory($boid);

                if ($success) {
                    echo json_encode(['success' => true, 'message' => 'Inventory created successfully.']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to create inventory.']);
                }
            } catch (Exception $e) {
                echo json_encode(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Branch Office ID (boid) is required.']);
        }
    }

    public function getInventories() {
        $inventories = $this->inventoryModel->fillArray();
        return json_encode($inventories);
    }

    public function getInventoryByID($invid) {
        if (!empty($invid)) {
            $inventory = $this->inventoryModel->getInventoryByID($invid);
            if ($inventory) {
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
