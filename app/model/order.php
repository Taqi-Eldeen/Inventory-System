<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Orders extends Model {
    private $orders;

    function __construct() {
        $this->orders = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray();  // Fill the orders array upon instantiation
    }

    // Populate the orders array with data fetched from the database
    function fillArray() {
        $this->orders = [];
        $result = $this->readOrders();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Directly store the row as an array, no need to create an object
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

    // Return the orders array
    function getOrders() {
        return $this->orders;
    }

    // Fetch all orders from the database
    function readOrders() {
        $sql = "SELECT * FROM orders"; // Assuming the table is called "orders"
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Insert a new order
    function insertOrder($boid, $userId, $mesg, $status) {
        // Get the supplier ID using the getSupplierId method
        $supplierid = $this->getSupplierId($userId);

        // If supplier ID is not found, return false
        if (!$supplierid) {
            echo "ERROR: Supplier ID not found.";
            return false;
        }

        // Now proceed with inserting the order with the correct supplier ID
        $insertOrderSql = "INSERT INTO orders (boid, supplierid, mesg, status) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($insertOrderSql);
        $stmt->bind_param("iiss", $boid, $supplierid, $mesg, $status);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the orders array
            return true;
        } else {
            echo "ERROR: Could not insert order. " . $this->db->error;
            return false;
        }
    }

    // Function to get Supplier ID based on userId
    public function getSupplierId($userId) {
        $userId = intval($userId); // Ensure that the userId is an integer
        $sql = "SELECT supplierid FROM supplier WHERE userid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $userId); // Bind the userId parameter
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row['supplierid']; // Return the supplier ID
        } else {
            return null; // If no supplier is found for the given userId
        }
    }

    // Delete an order by ID
    function deleteOrder($orderid) {
        $sql = "DELETE FROM orders WHERE orderid = ?"; // Use prepared statements to prevent SQL injection
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $orderid);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the orders array
            return true;
        } else {
            echo "ERROR: Could not delete order. " . $this->db->error;
            return false;
        }
    }

    // Update an existing order
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
            $this->fillArray(); // Refresh the orders array
            return true;
        } else {
            echo "ERROR: Could not execute $sql. " . $this->db->error;
            return false;
        }
    }

    // Function to get orders by business owner ID
    public function getOrdersByBusinessOwner($boid) {
        $sql = "SELECT * FROM orders WHERE boid = ?"; // Use prepared statement for security
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid); // Bind the boid
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row; // Add each order to the orders array
            }
            return $orders;
        } else {
            return false; // No orders found for the given business owner ID
        }
    }
    public function getOrdersBySupplier($supplierid) {
        $sql = "SELECT * FROM orders WHERE supplierid = ?"; // Use prepared statement for security
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $supplierid); // Bind the boid
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $orders = [];
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row; // Add each order to the orders array
            }
            return $orders;
        } else {
            return false; // No orders found for the given business owner ID
        }
    }
    public function updateOrderStatus($orderId, $status) {
        // Using MySQLi's ? placeholders instead of named placeholders
        $sql = "UPDATE orders SET status = ? WHERE orderid = ?";
        $stmt = $this->db->prepare($sql);

        // Bind the parameters (status as string, orderid as integer)
        $stmt->bind_param('si', $status, $orderId);

        return $stmt->execute(); // Returns true if successful, false otherwise
    }
}
?>
