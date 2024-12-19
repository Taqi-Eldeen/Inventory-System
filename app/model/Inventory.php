<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Inventory extends Model {
    private $invid;
    private $boid;
    private $productid;
    private $level;

    function __construct($invid = null, $boid = "", $productid = "", $level = "") {
        $this->db = $this->connect(); // Ensure DB connection
        if ($invid !== null) {
            $this->invid = $invid;
            $this->readInventory($invid); // Read inventory if ID is provided
        } else {
            // If no ID is passed, set default values
            $this->boid = $boid;
            $this->productid = $productid;
            $this->level = $level;
        }
    }

    // Getters and Setters
    function getInvid() {
        return $this->invid;
    }

    function getBoid() {
        return $this->boid;
    }

    function setBoid($boid) {
        $this->boid = $boid;
    }

    function getProductid() {
        return $this->productid;
    }

    function setProductid($productid) {
        $this->productid = $productid;
    }

    function getLevel() {
        return $this->level;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    // Fetch Inventory Details
    function readInventory($invid) {
        if (!empty($invid)) {
            $sql = "SELECT * FROM inventory WHERE invid = " . intval($invid); // Prevent SQL injection using intval
            $result = $this->db->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->boid = $row["boid"];
                $this->productid = $row["productid"];
                $this->level = $row["level"];
            } else {
                // If no inventory is found, set default values
                $this->boid = "";
                $this->productid = "";
                $this->level = "";
            }
        } else {
            echo "Inventory ID is required!";
        }
    }

    // Update Inventory
    function updateInventory() {
        $sql = "UPDATE inventory SET 
                boid = '" . $this->db->real_escape_string($this->boid) . "', 
                productid = '" . $this->db->real_escape_string($this->productid) . "', 
                level = '" . $this->db->real_escape_string($this->level) . "' 
                WHERE invid = " . intval($this->invid);

        return $this->db->query($sql);
    }

    // Delete Inventory
    function deleteInventory() {
        $sql = "DELETE FROM inventory WHERE invid = " . intval($this->invid);
        return $this->db->query($sql);
    }

    // Fetch all inventory entries from DB
    function getAllInventory() {
        $sql = "SELECT * FROM inventory";
        $result = $this->db->query($sql);
        $data = [];

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }
}
?>
