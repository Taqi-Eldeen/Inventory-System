<?php
require_once(dirname(__FILE__) . '/../model/order.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class OrdersController extends Controller {
    private $ordersModel;

    public function __construct() {
        $this->ordersModel = new Orders();
        parent::__construct($this->ordersModel);
    }

    // Insert a new order
    public function insert() {
        // Access $_POST data for creating the order
        $boid = $_SESSION['boid']; // Assuming the Business Owner ID is stored in session
        $supplierid = $_POST['supplierid']; // Get the supplier ID from the request
        $mesg = $_POST['mesg'];
        $status = $_POST['status'];

        // Prepare the order data and insert it into the database
        if (!empty($boid) && !empty($supplierid) && !empty($mesg) && !empty($status)) {
            return $this->ordersModel->insertOrder($boid, $supplierid, $mesg, $status);
        } else {
            echo "All fields are required to insert an order.";
            return false;
        }
    }

    // Edit an existing order
    public function edit() {
        $orderid = $_REQUEST['orderid'];
        $boid = $_REQUEST['boid'];
        $supplierid = $_REQUEST['supplierid'];
        $mesg = $_REQUEST['mesg'];
        $status = $_REQUEST['status'];

        if (!empty($orderid) && !empty($boid) && !empty($supplierid) && !empty($mesg) && !empty($status)) {
            return $this->ordersModel->updateOrder($orderid, $boid, $supplierid, $mesg, $status);
        } else {
            echo "All fields are required to edit an order.";
            return false;
        }
    }

    // Delete an order
    public function delete($orderid) {
        if (!empty($orderid)) {
            return $this->ordersModel->deleteOrder($orderid);
        } else {
            echo "Order ID is required to delete an order.";
            return false;
        }
    }

    // Get all orders
    public function getOrders() {
        return $this->ordersModel->getOrders();
    }

    // Get order details by order ID
    public function getOrderByID($orderid) {
        if (!empty($orderid)) {
            return $this->ordersModel->getOrderByID($orderid);
        } else {
            echo "Order ID is required to fetch details.";
            return null;
        }
    }

    // Method to fetch orders by supplier ID
public function getOrdersBySupplier($supplierid) {
    $orders = $this->ordersModel->getOrdersBySupplier($supplierid);
    return $orders;
}

   // Method to fetch orders by business owner ID (boid)
public function getOrdersByBusinessOwner($boid) {
    $orders = $this->ordersModel->getOrdersByBusinessOwner($boid);
    return $orders;
}

public function updateOrderStatus($orderId, $status) {
    return $this->ordersModel->updateOrderStatus($orderId, $status);  // Delegate to model
}

    // Other controller methods can go here
}
?>
