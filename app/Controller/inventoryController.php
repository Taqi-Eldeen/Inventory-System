<?php
require_once(dirname(__FILE__) . '/../model/Inventories.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');
require_once(dirname(__FILE__) . '/../model/SupplierObserver.php'); // Include SupplierObserver
require_once(dirname(__FILE__) . '/../model/Subject.php');

class InventoryController extends Controller implements Subject {
    private $inventoryModel;
    private $observers = []; // Array to hold observers

    public function __construct() {
        $this->inventoryModel = new Inventories();
        parent::__construct($this->inventoryModel);
    }

    // Attach an observer
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    // Detach an observer
    public function detach(Observer $observer) {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    // Notify all observers
    public function notify($supplierEmail, $product) {
        foreach ($this->observers as $observer) {
            $observer->update($this, $supplierEmail, $product);
        }
    }
    
    

    // Remove product and notify observers
    public function removeProduct($productId) {
        if (!empty($productId)) {
            $product = $this->inventoryModel->getProductById($productId);
            
            if ($product) {
                // Get the supplier's email using the supplier ID
                $supplierEmail = $this->inventoryModel->getSupplierEmailById($product['supplierid']);
                
                // Get the business owner's email using the inventory ID
                $boEmail = $this->inventoryModel->getBownerEmailById($product['invid']);
    
                // Remove the product from the inventory
                $success = $this->inventoryModel->deleteProductByIdInInventory($productId);
    
                if ($success) {
                    // Notify the supplier if the email is available
                    if ($supplierEmail) {
                        $this->notify($supplierEmail, $product); // Notify the supplier
                    }
    
                    // Notify the business owner if the email is available
                    if ($boEmail) {
                        $this->notify($boEmail, $product); // Notify the business owner
                    }
    
                    return json_encode(['success' => true, 'message' => 'Product removed successfully, supplier and business owner notified.']);
                } else {
                    return json_encode(['success' => false, 'message' => 'Failed to remove product.']);
                }
            } else {
                return json_encode(['success' => false, 'message' => 'Product not found.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Product ID is required.']);
        }
    }
    
    

    // Fetch or create inventory for a business owner
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

    // Fetch all inventories
    public function getInventories() {
        $inventories = $this->inventoryModel->fillArray();
        return json_encode($inventories);
    }

    // Fetch a specific inventory by its ID
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

    // Delete an inventory by its ID
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

    // Add a new product to inventory and notify the business owner
    public function addProduct($productDetails) {
        if (!empty($productDetails)) {
            // Insert product into inventory
            $success = $this->inventoryModel->insertProduct($productDetails);
    
            if ($success) {
                // Fetch business owner's email
                $inventoryId = $productDetails['invid'];
                $businessOwnerEmail = $this->inventoryModel->getBusinessOwnerEmailByInventoryId($inventoryId);
    
                // If the product was added successfully, create the product data and notify observers
                if ($businessOwnerEmail) {
                    // Attach BusinessOwnerObserver to notify business owner about the new product
                    $this->attach(new BusinessOwnerObserver());
    
                    // Notify the observers (BusinessOwner) with product details
                    $this->notify($businessOwnerEmail, $productDetails);
    
                }
    
                return json_encode(['success' => true, 'message' => 'Product added successfully and business owner notified.']);
            } else {
                return json_encode(['success' => false, 'message' => 'Failed to add product.']);
            }
        } else {
            return json_encode(['success' => false, 'message' => 'Product details are required.']);
        }
    }
    

    // Fetch inventory information for a specific employee
    public function getInventoryForEmployee($empid) {
        $invid = $this->inventoryModel->getInventoryForEmployee($empid);
        
        if ($invid) {
            // Get products for this inventory
            $products = $this->inventoryModel->getProductsByInventoryID($invid);
            return $products;
        } else {
            return null;
        }
    }
}
?>
