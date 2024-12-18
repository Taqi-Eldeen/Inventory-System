<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Product extends Model {
    private $id;
    private $name;
    private $price;
    private $qty;
    private $supplierid;

    function __construct($id = null, $name = "", $price = "", $qty = "", $supplierid = "") {
        $this->db = $this->connect(); // Ensure DB connection
        if ($id !== null) {
            $this->id = $id;
            $this->readProduct($id); // Read product if ID is provided
        } else {
            // If no ID is passed, set default values
            $this->name = $name;
            $this->price = $price;
            $this->qty = $qty;
            $this->supplierid = $supplierid;
        }
    }

    // Getters and Setters
    function getID() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

    function getPrice() {
        return $this->price;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function getQty() {
        return $this->qty;
    }

    function setQty($qty) {
        $this->qty = $qty;
    }

    function getsupplierid() {
        return $this->supplierid;
    }

    function setsupplierid($supplierid) {
        $this->supplierid = $supplierid;
    }

    // Fetch Product Details
    function readProduct($id) {
        if (!empty($id)) {
            $sql = "SELECT * FROM product WHERE id = " . intval($id); // Prevent SQL injection using intval
            $result = $this->db->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->name = $row["name"];
                $this->price = $row["price"];
                $this->qty = $row["qty"];
                $this->supplierid = $row["supplierid"];
            } else {
                // If no product is found, set default values
                $this->name = "";
                $this->price = "";
                $this->qty = "";
                $this->supplierid = "";
            }
        } else {
            echo "Product ID is required!";
        }
    }

    // Update Product
    function updateProduct() {
        $sql = "UPDATE product SET 
                name = '" . $this->db->real_escape_string($this->name) . "', 
                price = '" . $this->db->real_escape_string($this->price) . "', 
                qty = '" . $this->db->real_escape_string($this->qty) . "', 
                supplierid = '" . $this->db->real_escape_string($this->supplierid) . "' 
                WHERE id = " . intval($this->id);

        return $this->db->query($sql);
    }

    // Delete Product
    function deleteProduct() {
        $sql = "DELETE FROM product WHERE id = " . intval($this->id);
        return $this->db->query($sql);
    }

    // Fetch all products from DB
    public static function SelectAllProductsInDB() {
        $db = new DatabaseHandler(); // Use DBh to get a connection
        $sql = "SELECT * FROM product";
        return $db->query($sql);
    }

    public static function SelectProductsBySupplier($supplierID) {
        $db = new DatabaseHandler();
        $sql = "SELECT * FROM product WHERE userid = " . intval($supplierID);
        $result = $db->query($sql);
    
        // Check if any results were found and return them as an associative array
        if ($result) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = $row; // Add each product to the array
            }
            return $products;
        } else {
            return []; // Return an empty array if no products are found
        }
    }
    
}
?>
