<?php
include "DBConnection.php";

class Product {
    public $ID;
    public $name;
    public $price;
    public $qty;
    public $userID;

    function __construct($id) {
        if ($id != "") {
            $sql = "SELECT * FROM product WHERE id = $id";
            $Product = mysqli_query($GLOBALS['conn'], $sql);
            if ($row = mysqli_fetch_array($Product)) {
                $this->ID = $row["id"];
                $this->name = $row["name"];
                $this->price = $row["price"];
                $this->qty = $row["qty"];
                $this->userID = $row["userid"];
            }
        }
    }

   static function InsertProductInDB_Static($name, $price, $qty, $supplierID) {
    $sql = "INSERT INTO product (name, price, qty, userid) VALUES ('$name', '$price', '$qty', '$supplierID')";
    if (mysqli_query($GLOBALS['conn'], $sql)) {
        return true;
    } else {
        return false;
    }
}

    static function SelectAllProductsInDB() {
        $sql = "SELECT * FROM product";
        $Products = mysqli_query($GLOBALS['conn'], $sql);

        if (!$Products) {
            die("Query failed: " . mysqli_error($GLOBALS['conn']));
        }

        $Result = [];
        $i = 0;

        while ($row = mysqli_fetch_array($Products)) {
            $MyObj = new Product($row["id"]);
            $Result[$i] = $MyObj;
            $i++;
        }

        return $Result;
    }
    static function SelectProductsBySupplier($supplierID) {
        $sql = "SELECT * FROM product WHERE userid = '$supplierID'";
        $Products = mysqli_query($GLOBALS['conn'], $sql);

        if (!$Products) {
            die("Query failed: " . mysqli_error($GLOBALS['conn']));
        }

        $Result = [];
        $i = 0;

        while ($row = mysqli_fetch_array($Products)) {
            $MyObj = new Product($row["id"]);
            $Result[$i] = $MyObj;
            $i++;
        }

        return $Result;
    }

    function UpdateProductInDB() {
        $sql = "UPDATE product SET name='" . mysqli_real_escape_string($GLOBALS['conn'], $this->name) . "', price='" . mysqli_real_escape_string($GLOBALS['conn'], $this->price) . "', qty='" . mysqli_real_escape_string($GLOBALS['conn'], $this->qty) . "', userid='" . mysqli_real_escape_string($GLOBALS['conn'], $this->userID) . "' WHERE id=" . intval($this->ID);
        
        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true;
        } else {
            return false;
        }
    }
    

    static function deleteProduct($ObjProduct) {
        $sql = "DELETE FROM product WHERE id=" . $ObjProduct->ID;
        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
