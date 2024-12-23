<?php
require_once(dirname(__FILE__) . '/../model/Products.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');


class ProductsController extends Controller {
    private $productsModel;

    public function __construct() {
        $this->productsModel = new Products();
        parent::__construct($this->productsModel);
    }

    
    public function insert() {
        
        $name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $supplierid = $_SESSION['supplierid']; 

        
        $invid = $this->getInventoryForSupplier($supplierid);

        
        if ($invid) {
            return $this->productsModel->insertProduct($name, $price, $qty, $supplierid, $invid);
        } else {
            return false;  
        }
    }

    
    public function edit() {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $price = $_REQUEST['price'];
        $qty = $_REQUEST['qty'];
        $supplierid = $_REQUEST['supplierid'];

        if (!empty($id) && !empty($name) && !empty($price) && !empty($qty) && !empty($supplierid)) {
            return $this->productsModel->updateProduct($id, $name, $price, $qty, $supplierid);
        } else {
            echo "All fields are required to edit a product.";
            return false;
        }
    }

    
    public function delete($id) {
        if (!empty($id)) {
            return $this->productsModel->deleteProduct($id);
        } else {
            echo "Product ID is required to delete a product.";
            return false;
        }
    }

    
    public function getProducts() {
        return $this->productsModel->getProducts();
    }

    
    public function getProductByID($id) {
        if (!empty($id)) {
            return $this->productsModel->getProductByID($id);
        } else {
            echo "Product ID is required to fetch details.";
            return null;
        }
    }

    
    public function getInventoryForSupplier($supplierid) {
        return $this->productsModel->getInventoryForSupplier($supplierid);
    }

    
    public function ProductsBySupplier($supplierid) {
        
        $products = $this->productsModel->getProductsBySupplier($supplierid);

        
        if ($products) {
            return $products; 
        } else {
            return false; 
        }
    }

    public function ProductsByBusinessOwner($boid) {
        
        $products = $this->productsModel->getProductsByBusinessOwner($boid);

        
        if ($products) {
            return $products; 
        } else {
            return false; 
        }
    }
    
}


?>
