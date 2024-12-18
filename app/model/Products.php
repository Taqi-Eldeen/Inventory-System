<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/Product.php');

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
                    $row["supplierid"]
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

    function insertProduct($name, $price, $qty, $userid) {
        // Step 1: Fetch supplierid based on userid
        $getSupplierIdSql = "SELECT supplierid FROM supplier WHERE userid = ?";
        $stmt = $this->db->prepare($getSupplierIdSql);
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows === 0) {
            // If no supplierid exists for the given userid, show an error
            echo "ERROR: No supplier found with User ID $userid.";
            return;
        }
    
        // Fetch the supplierid
        $row = $result->fetch_assoc();
        $supplierid = $row['supplierid'];
    
        // Step 2: Insert the product using the dynamically fetched supplierid
        $insertProductSql = "INSERT INTO product (name, price, qty, supplierid) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertProductSql);
        $stmt->bind_param("siii", $name, $price, $qty, $supplierid);
    
        if ($stmt->execute()) {
            echo "Product inserted successfully with Supplier ID $supplierid.";
            $this->fillArray(); // Refresh the products array
        } else {
            echo "ERROR: Could not insert product. " . $this->db->error;
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
    function updateProduct($id, $name, $price, $qty, $supplierid) {
        $sql = "UPDATE product SET 
                    name = '$name', 
                    price = '$price', 
                    qty = '$qty', 
                    supplierid = '$supplierid'
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