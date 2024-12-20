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
                    $row["supplierid"],
                    $row["invid"]  // Add inventory ID to product object
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

    // Insert a new product with supplierid and invid (inventory ID)
    function insertProduct($name, $price, $qty, $supplierid, $invid) {
        // Step 3: Insert the product using the provided supplierid and invid
        $insertProductSql = "INSERT INTO product (name, price, qty, supplierid, invid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertProductSql);
        $stmt->bind_param("siiii", $name, $price, $qty, $supplierid, $invid);
    
        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the products array
            return true;
        } else {
            echo "ERROR: Could not insert product. " . $this->db->error;
            return false;
        }
    }
    

    // Delete a product by ID
    function deleteProduct($id) {
        $sql = "DELETE FROM product WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            $this->fillArray(); // Refresh the products array
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    // Update an existing product
    function updateProduct($id, $name, $price, $qty, $supplierid, $invid) {
        $sql = "UPDATE product SET 
                    name = ?, 
                    price = ?, 
                    qty = ?, 
                    supplierid = ?,
                    invid = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siiii", $name, $price, $qty, $supplierid, $invid, $id);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the products array
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    // Function to get inventory ID (invid) based on supplier's supplierid
    public function getInventoryForSupplier($supplierid) {
        // Step 1: Fetch boid (Business Owner ID) based on supplierid
        $getBoidSql = "SELECT boid FROM supplier WHERE supplierid = ?";
        $stmt = $this->db->prepare($getBoidSql);
        $stmt->bind_param("i", $supplierid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Step 2: If no supplier found, return an error message
        if ($result->num_rows === 0) {
            echo "ERROR: No supplier found with Supplier ID $supplierid.";
            return false;
        }

        // Fetch the boid from the result
        $row = $result->fetch_assoc();
        $boid = $row['boid'];

        // Step 3: Fetch invid (Inventory ID) for the business owner (boid)
        $getInvidSql = "SELECT invid FROM inventory WHERE boid = ?";
        $stmt = $this->db->prepare($getInvidSql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();

        // Step 4: If no inventory found for the business owner, return an error
        if ($result->num_rows === 0) {
            echo "ERROR: No inventory found for Business Owner ID $boid.";
            return false;
        }

        // Fetch the invid
        $row = $result->fetch_assoc();
        $invid = $row['invid'];

        // Return the invid (Inventory ID) associated with the supplier
        return $invid;
    }
}
?>
