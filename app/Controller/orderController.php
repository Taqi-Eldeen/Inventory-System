<?php
require_once(dirname(__FILE__) . '/../model/order.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class OrdersController extends Controller {
    private $ordersModel;

    public function __construct() {
        $this->ordersModel = new Orders();
        parent::__construct($this->ordersModel);
    }

    
    public function insert() {
        
        $boid = $_SESSION['boid']; 
        $supplierid = $_POST['supplierid']; 
        $mesg = $_POST['mesg'];
        $status = $_POST['status'];

        
        if (!empty($boid) && !empty($supplierid) && !empty($mesg) && !empty($status)) {
            return $this->ordersModel->insertOrder($boid, $supplierid, $mesg, $status);
        } else {
            echo "All fields are required to insert an order.";
            return false;
        }
    }

    
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

    
    public function delete($orderid) {
        if (!empty($orderid)) {
            return $this->ordersModel->deleteOrder($orderid);
        } else {
            echo "Order ID is required to delete an order.";
            return false;
        }
    }

    
    public function getOrders() {
        return $this->ordersModel->getOrders();
    }

    
    public function getOrderByID($orderid) {
        if (!empty($orderid)) {
            return $this->ordersModel->getOrderByID($orderid);
        } else {
            echo "Order ID is required to fetch details.";
            return null;
        }
    }

    
public function getOrdersBySupplier($supplierid) {
    $orders = $this->ordersModel->getOrdersBySupplier($supplierid);
    return $orders;
}

   
public function getOrdersByBusinessOwner($boid) {
    $orders = $this->ordersModel->getOrdersByBusinessOwner($boid);
    return $orders;
}

public function updateOrderStatus($orderId, $status) {
    return $this->ordersModel->updateOrderStatus($orderId, $status);  
}

    
}
?>
