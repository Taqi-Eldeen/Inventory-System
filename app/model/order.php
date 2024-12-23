<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Orders extends Model {
    private $orders;

    function __construct() {
        $this->orders = [];
        $this->db = $this->connect(); 
        $this->fillArray();  
    }

    
    function fillArray() {
        $this->orders = [];
        $result = $this->readOrders();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                
                $this->orders[] = [
                    "orderid" => $row["orderid"],
                    "boid" => $row["boid"],
                    "supplierid" => $row["supplierid"],
                    "mesg" => $row["mesg"],
                    "status" => $row["status"]
                ];
            }
        }
    }

    
    function getOrders() {
        return $this->orders;
    }

    
    function readOrders() {
        $sql = "SELECT * FROM orders"; 
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    
    function insertOrder($boid, $userId, $mesg, $status) {
        
        $supplierid = $this->getSupplierId($userId);

        
        if (!$supplierid) {
            echo "ERROR: Supplier ID not found.";
            return false;
        }

        
        $insertOrderSql = "INSERT INTO orders (boid, supplierid, mesg, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertOrderSql);
        $stmt->bind_param("iiss", $boid, $supplierid, $mesg, $status);

        if ($stmt->execute()) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not insert order. " . $this->db->error;
            return false;
        }
    }

    
    public function getSupplierId($userId) {
        $userId = intval($userId); 
        $sql = "SELECT supplierid FROM supplier WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['supplierid']; 
        } else {
            return null; 
        }
    }

    
    function deleteOrder($orderid) {
        $sql = "DELETE FROM orders WHERE orderid = ?"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderid);

        if ($stmt->execute()) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not delete order. " . $this->db->error;
            return false;
        }
    }

    
    function updateOrder($orderid, $boid, $supplierid, $mesg, $status) {
        $sql = "UPDATE orders SET 
                    boid = ?, 
                    supplierid = ?, 
                    mesg = ?, 
                    status = ? 
                WHERE orderid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iissi", $boid, $supplierid, $mesg, $status, $orderid);

        if ($stmt->execute()) {
            $this->fillArray(); 
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    
    public function getOrdersByBusinessOwner($boid) {
        $sql = "SELECT * FROM orders WHERE boid = ?"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row; 
            }
            return $orders;
        } else {
            return false; 
        }
    }
    public function getOrdersBySupplier($supplierid) {
        $sql = "SELECT * FROM orders WHERE supplierid = ?"; 
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $supplierid); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row; 
            }
            return $orders;
        } else {
            return false; 
        }
    }
    public function updateOrderStatus($orderId, $status) {
        
        $sql = "UPDATE orders SET status = ? WHERE orderid = ?";
        $stmt = $this->db->prepare($sql);

        
        $stmt->bind_param('si', $status, $orderId);

        return $stmt->execute(); 
    }
}
?>
