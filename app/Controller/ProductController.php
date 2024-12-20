<?php
require_once(dirname(__FILE__) . '/../model/Products.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class ProductsController extends Controller {
    private $productsModel;

    public function __construct() {
        $this->productsModel = new Products();
        parent::__construct($this->productsModel);
    }

    // Insert a new product
    public function insert() {
        // Access $_POST directly within the method
        $name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $supplierid = $_SESSION['supplierid']; // Fetch the supplier ID from the session

        // Get the corresponding inventory ID for the supplier
        $invid = $this->getInventoryForSupplier($supplierid);

        // Prepare the product data and insert it into the database
        if ($invid) {
            return $this->productsModel->insertProduct($name, $price, $qty, $supplierid, $invid);
        } else {
            return false;  // If no valid inventory found, return false
        }
    }

    // Edit an existing product
    public function edit() {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $price = $_REQUEST['price'];
        $qty = $_REQUEST['qty'];
        $supplierid = $_REQUEST['supplierid'];
        $invid = $_REQUEST['invid'];

        if (!empty($id) && !empty($name) && !empty($price) && !empty($qty) && !empty($supplierid) && !empty($invid)) {
            return $this->productsModel->updateProduct($id, $name, $price, $qty, $supplierid, $invid);
        } else {
            echo "All fields are required to edit a product.";
            return false;
        }
    }

    // Delete a product
    public function delete($id) {
        if (!empty($id)) {
            return $this->productsModel->deleteProduct($id);
        } else {
            echo "Product ID is required to delete a product.";
            return false;
        }
    }

    // Get all products
    public function getProducts() {
        return $this->productsModel->getProducts();
    }

    // Get product details by ID
    public function getProductByID($id) {
        if (!empty($id)) {
            return $this->productsModel->getProductByID($id);
        } else {
            echo "Product ID is required to fetch details.";
            return null;
        }
    }

    // Get inventory for a supplier
    public function getInventoryForSupplier($supplierid) {
        return $this->productsModel->getInventoryForSupplier($supplierid);
    }
}
?>
