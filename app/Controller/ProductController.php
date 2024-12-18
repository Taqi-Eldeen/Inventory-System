<?php
// Include the Product and Products models and the base Controller
require_once __DIR__ . "/../Config/DBConnection.php";

require_once(dirname(__FILE__) . '/../model/Products.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class ProductsController extends Controller {
    private $productsModel; // Instance of the Products class

    public function __construct() {
        $this->productsModel = new Products(); // Initialize the Products model
        parent::__construct($this->productsModel); // Pass the model to the parent constructor
    }

    // Insert a new product
    public function insert() {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $supplierid = $_POST['supplierid'];

        if (!empty($name) && !empty($price) && !empty($qty) && !empty($supplierid)) {
            $this->productsModel->insertProduct($name, $price, $qty, $supplierid);
        } else {
            echo "All fields are required to insert a product.";
        }
    }

    // Edit an existing product
    public function edit() {
        $id = $_REQUEST['id'];
        $name = $_REQUEST['name'];
        $price = $_REQUEST['price'];
        $qty = $_REQUEST['qty'];
        $supplierid = $_REQUEST['supplierid'];

        if (!empty($id) && !empty($name) && !empty($price) && !empty($qty) && !empty($supplierid)) {
            $this->productsModel->updateProduct($id, $name, $price, $qty, $supplierid);
        } else {
            echo "All fields are required to edit a product.";
        }
    }

    // Delete a product by ID
    public function delete($id) {
        if (!empty($id)) {
            $this->productsModel->deleteProduct($id);
        } else {
            echo "Product ID is required to delete a product.";
        }
    }

    // Get all products
    public function getProducts() {
        // Fetch all products using the Products model
        return $this->productsModel->getProducts();
    }

    // Get product details by ID
    public function getProductByID($id) {
        if (!empty($id)) {
            $product = new Products($id);
            return [
                "id" => $product->getID(),
                "name" => $product->getName(),
                "price" => $product->getPrice(),
                "qty" => $product->getQty(),
                "supplierid" => $product->getsupplierid()
            ];
        } else {
            echo "Product ID is required to fetch details.";
            return null;
        }
    }
}
?>
