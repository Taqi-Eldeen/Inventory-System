<?php
require_once(dirname(__FILE__) . '/../model/Inventories.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');
require_once(dirname(__FILE__) . '/../model/SupplierObserver.php'); 
require_once(dirname(__FILE__) . '/../model/Subject.php');

class InventoryController extends Controller implements Subject {
    private $inventoryModel;
    private $observers = []; 

    public function __construct() {
        $this->inventoryModel = new Inventories();
        parent::__construct($this->inventoryModel);
    }

    
    public function attach(Observer $observer) {
        $this->observers[] = $observer;
    }

    
    public function detach(Observer $observer) {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    
    public function notify($supplierEmail, $product) {
        foreach ($this->observers as $observer) {
            $observer->update($this, $supplierEmail, $product);
        }
    }
    
    

    
    public function removeProduct($productId) {
        if (!empty($productId)) {
            $product = $this->inventoryModel->getProductById($productId);
            
            if ($product) {
                
                $supplierEmail = $this->inventoryModel->getSupplierEmailById($product['supplierid']);
                
                
                $boEmail = $this->inventoryModel->getBownerEmailById($product['invid']);
    
                
                $success = $this->inventoryModel->deleteProductByIdInInventory($productId);
    
                if ($success) {
                    
                    if ($supplierEmail) {
                        $this->notify($supplierEmail, $product); 
                    }
    
                    
                    if ($boEmail) {
                        $this->notify($boEmail, $product); 
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
    
    

    
    public function getOrCreateInventory($boid) {
        if (!empty($boid)) {
            $inventory = $this->inventoryModel->getInventoryByBOID($boid);
            
            if ($inventory) {
                
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

    
    public function addProduct($productDetails) {
        if (!empty($productDetails)) {
            
            $success = $this->inventoryModel->insertProduct($productDetails);
    
            if ($success) {
                
                $inventoryId = $productDetails['invid'];
                $businessOwnerEmail = $this->inventoryModel->getBusinessOwnerEmailByInventoryId($inventoryId);
    
                
                if ($businessOwnerEmail) {
                    
                    $this->attach(new BusinessOwnerObserver());
    
                    
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
    

    
    public function getInventoryForEmployee($empid) {
        $invid = $this->inventoryModel->getInventoryForEmployee($empid);
        
        if ($invid) {
            
            $products = $this->inventoryModel->getProductsByInventoryID($invid);
            return $products;
        } else {
            return null;
        }
    }
}
?>
