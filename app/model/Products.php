<?php
require_once(__ROOT__ . "model/Model.php");
require_once(__ROOT__ . "model/Product.php");

class Products extends Model {
    private $products;

    function __construct() {
        $this->products = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray();
    }

    // Populate the products array
    function fillArray() {
        $this->products = [];
        $result = $this->readProducts();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $product = new Product(
                    $row["id"], 
                    $row["name"], 
                    $row["price"], 
                    $row["qty"], 
                    $row["userid"]
                );
                array_push($this->products, $product);
            }
        }
    }

    // Return the products array
    function getProducts() {
        return $this->products;
    }

    // Fetch all products from the database
    function readProducts() {
        $sql = "SELECT * FROM product";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Insert a new product into the database
    function insertProduct($name, $price, $qty, $userID) {
        $sql = "INSERT INTO product (name, price, qty, userid) 
                VALUES ('$name', '$price', '$qty', '$userID')";

        if ($this->db->query($sql) === true) {
            echo "Product inserted successfully.";
            $this->fillArray(); // Refresh the products array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    // Delete a product by ID
    function deleteProduct($id) {
        $sql = "DELETE FROM product WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            echo "Product deleted successfully.";
            $this->fillArray(); // Refresh the products array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }

    // Update an existing product
    function updateProduct($id, $name, $price, $qty, $userID) {
        $sql = "UPDATE product SET 
                    name = '$name', 
                    price = '$price', 
                    qty = '$qty', 
                    userid = '$userID'
                WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            echo "Product updated successfully.";
            $this->fillArray(); // Refresh the products array
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
        }
    }
}
?>
