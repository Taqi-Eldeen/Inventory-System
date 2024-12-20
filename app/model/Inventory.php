<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Inventory extends Model {
    private $invid;
    private $boid;

    function __construct($invid = null, $boid = "") {
        $this->db = $this->connect();

        if ($invid !== null) {
            $this->invid = $invid;
            $this->readInventory($invid);
        } else {
            $this->boid = $boid;
        }
    }

    function getInvid() {
        return $this->invid;
    }

    function getBoid() {
        return $this->boid;
    }

    function setBoid($boid) {
        $this->boid = $boid;
    }

    function readInventory($invid) {
        if (!empty($invid)) {
            $sql = "SELECT * FROM inventory WHERE invid = " . intval($invid);
            $result = $this->db->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $this->boid = $row["boid"];
            } else {
                $this->boid = "";
            }
        } else {
            echo "Inventory ID is required!";
        }
    }
}
?>
