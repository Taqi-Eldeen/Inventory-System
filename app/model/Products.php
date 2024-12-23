<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/Product.php');

class Products extends Model {
    private $products;

    function __construct() {
        $this->products = [];
        $this->db = $this->connect(); 
        $this->fillArray();
    }

    
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
                    $row["invid"]  
                );
                array_push($this->products, $product);
            }
        }
    }

    
    function getProducts() {
        return $this->products;
    }

    
    function readProducts() {
        $sql = "SELECT * FROM product";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    
    function insertProduct($name, $price, $qty, $supplierid, $invid) {
        
        $insertProductSql = "INSERT INTO product (name, price, qty, supplierid, invid) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertProductSql);
        $stmt->bind_param("siiii", $name, $price, $qty, $supplierid, $invid);
    
        if ($stmt->execute()) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not insert product. " . $this->db->error;
            return false;
        }
    }
    

    
    function deleteProduct($id) {
        $sql = "DELETE FROM product WHERE id = " . intval($id);

        if ($this->db->query($sql) === true) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    
    function updateProduct($id, $name, $price, $qty, $supplierid) {
        $sql = "UPDATE product SET 
                    name = ?, 
                    price = ?, 
                    qty = ?, 
                    supplierid = ?
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("siiii", $name, $price, $qty, $supplierid, $id);

        if ($stmt->execute()) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    
    public function getInventoryForSupplier($supplierid) {
        
        $getBoidSql = "SELECT boid FROM supplier WHERE supplierid = ?";
        $stmt = $this->db->prepare($getBoidSql);
        $stmt->bind_param("i", $supplierid);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows === 0) {
            echo "ERROR: No supplier found with Supplier ID $supplierid.";
            return false;
        }

        
        $row = $result->fetch_assoc();
        $boid = $row['boid'];

        
        $getInvidSql = "SELECT invid FROM inventory WHERE boid = ?";
        $stmt = $this->db->prepare($getInvidSql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows === 0) {
            echo "ERROR: No inventory found for Business Owner ID $boid.";
            return false;
        }

        
        $row = $result->fetch_assoc();
        $invid = $row['invid'];

        
        return $invid;
    }
    
    public function getProductsBySupplier($supplierid) {
        
        $sql = "SELECT * FROM product WHERE supplierid = $supplierid"; 
    
        
        $result = $this->db->query($sql);
    
        
        if ($result && $result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                
                $products[] = $row; 
            }
            return $products; 
        } else {
            return false; 
        }
    }

    public function getProductsByBusinessOwner($boid) {
        $sql = "SELECT * FROM product JOIN inventory ON product.invid = inventory.invid WHERE inventory.boid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid);
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result && $result->num_rows > 0) {
            $products = [];
            while ($row = $result->fetch_assoc()) {
                
                $product = new Product(
                    $row["id"],
                    $row["name"],
                    $row["price"],
                    $row["supplierid"],
                    $row["qty"]
                );
                array_push($products, $product);
            }
                    
            return $products; 
        } else {
            return false; 
        }
    }


}
?>
