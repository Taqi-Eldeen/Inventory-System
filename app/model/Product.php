<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Product extends Model {
    private $id;
    private $name;
    private $price;
    private $qty;
    private $supplierid;

    function __construct($id = null, $name = "", $price = "", $qty = "", $supplierid = "") {
        $this->db = $this->connect(); 
        if ($id !== null) {
            $this->id = $id;
            $this->readProduct($id); 
        } else {
            
            $this->name = $name;
            $this->price = $price;
            $this->qty = $qty;
            $this->supplierid = $supplierid;
        }
    }

    
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

    
    function readProduct($id) {
        if (!empty($id)) {
            $sql = "SELECT * FROM product WHERE id = " . intval($id); 
            $result = $this->db->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->name = $row["name"];
                $this->price = $row["price"];
                $this->qty = $row["qty"];
                $this->supplierid = $row["supplierid"];
            } else {
                
                $this->name = "";
                $this->price = "";
                $this->qty = "";
                $this->supplierid = "";
            }
        } else {
            echo "Product ID is required!";
        }
    }

    
    function updateProduct() {
        $sql = "UPDATE product SET 
                name = '" . $this->db->real_escape_string($this->name) . "', 
                price = '" . $this->db->real_escape_string($this->price) . "', 
                qty = '" . $this->db->real_escape_string($this->qty) . "', 
                supplierid = '" . $this->db->real_escape_string($this->supplierid) . "' 
                WHERE id = " . intval($this->id);

        return $this->db->query($sql);
    }

    
    function deleteProduct() {
        $sql = "DELETE FROM product WHERE id = " . intval($this->id);
        return $this->db->query($sql);
    }

    

}
?>
