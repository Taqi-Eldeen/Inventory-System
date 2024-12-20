<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/Inventory.php');

class Inventories extends Model {
    private $inventories;

    public function __construct() {
        $this->inventories = [];
        $this->db = $this->connect();
        $this->fillArray();
    }

    public function fillArray() {
        $this->inventories = [];
        $result = $this->readInventories();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $inventory = new Inventory($row["invid"], $row["boid"]);
                $this->inventories[] = $inventory;
            }
        }
    }

    public function insertInventory($boid) {
        $sql = "INSERT INTO inventory (boid) VALUES (?)";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid);

        if ($stmt->execute()) {
            $this->fillArray();
            return true;
        } else {
            return false;
        }
    }

    public function deleteInventory($invid) {
        $sql = "DELETE FROM inventory WHERE invid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $invid);

        if ($stmt->execute()) {
            $this->fillArray();
            return true;
        } else {
            return false;
        }
    }
}
?>
