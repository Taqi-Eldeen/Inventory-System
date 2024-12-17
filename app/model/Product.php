<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Product extends Model {
    private $id;
    private $name;
    private $price;
    private $qty;
    private $userID;

    function __construct($id, $name = "", $price = "", $qty = "", $userID = "") {
        $this->id = $id;
        $this->db = $this->connect();

        if ($name === "") {
            $this->readProduct($id);
        } else {
            $this->name = $name;
            $this->price = $price;
            $this->qty = $qty;
            $this->userID = $userID;
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

    function getUserID() {
        return $this->userID;
    }
    function setUserID($userID) {
        $this->userID = $userID;
    }

    // Fetch Product Details
    function readProduct($id) {
        $sql = "SELECT * FROM product WHERE id = $id";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $this->name = $row["name"];
            $this->price = $row["price"];
            $this->qty = $row["qty"];
            $this->userID = $row["userid"];
        } else {
            $this->name = "";
            $this->price = "";
            $this->qty = "";
            $this->userID = "";
        }
    }

    // Update Product
    function updateProduct() {
        $sql = "UPDATE product SET 
                name = '" . $this->db->real_escape_string($this->name) . "', 
                price = '" . $this->db->real_escape_string($this->price) . "', 
                qty = '" . $this->db->real_escape_string($this->qty) . "', 
                userid = '" . $this->db->real_escape_string($this->userID) . "' 
                WHERE id = " . intval($this->id);

        return $this->db->query($sql);
    }

    // Delete Product
    function deleteProduct() {
        $sql = "DELETE FROM product WHERE id = " . intval($this->id);
        return $this->db->query($sql);
    }
}
?>
