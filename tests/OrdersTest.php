<?php
require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/Users.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/order.php');  
use PHPUnit\Framework\TestCase;

class OrdersTest extends TestCase
{
    public static $boid;
    public static $supplierid;
    public static $supplieruserid;
    public static $db;

    protected function setUp(): void
    {
        $this->db = DatabaseHandler::getInstance();
        $this->db->setTestDB();
        
        $this->db->query("TRUNCATE TABLE pages");
        $this->db->query("TRUNCATE TABLE employee");
        $this->db->query("TRUNCATE TABLE report");
        $this->db->query("TRUNCATE TABLE orders");
        $this->db->query("TRUNCATE TABLE product");
        $this->db->query("TRUNCATE TABLE supplier");
        $this->db->query("TRUNCATE TABLE bowner");
        $this->db->query("TRUNCATE TABLE inventory");
        $this->db->query("TRUNCATE TABLE user");

        // Create prerequisite data
        $usersModal = new Users();
        $bowner = $usersModal->signUpBusinessOwner("testBowner", "bowner@test.com", "pass123@");
        $bownerQuery = $this->db->query("SELECT * FROM bowner ORDER BY boid DESC LIMIT 1");
        $bownerData = $this->db->fetchRow($bownerQuery);
        $this->boid = $bownerData['boid'];

        // Create a supplier
        $username = "supplier1";
        $email = "supplier@test.com";
        $password = "pass123@";
        $type = 1;
        $usersModal->insertUserbo($username, $email, $password, $type, $this->boid);
        $query = $this->db->query("SELECT userid, supplierid FROM supplier ORDER BY supplierid DESC LIMIT 1");
        $row = $this->db->fetchRow($query);
        $this->supplierid = $row['supplierid'];
        $this->supplieruserid = $row['userid'];
    }

    protected function tearDown(): void
    {
        $this->db->resetDBConnection();
    }

    public function testOrderCreation()
    {
        $orderModel = new Orders();
        $mesg = "Test order message";
        $status = "pending";

        $result = $orderModel->insertOrder($this->boid, $this->supplieruserid, $mesg, $status);
        $this->assertTrue($result);

        $query = $this->db->query("SELECT * FROM orders ORDER BY orderid DESC LIMIT 1");
        $row = $this->db->fetchRow($query);

        $this->assertEquals($this->boid, $row['boid']);
        $this->assertEquals($this->supplierid, $row['supplierid']);
        $this->assertEquals($mesg, $row['mesg']);
        $this->assertEquals($status, $row['status']);
    }

    public function testOrderStatusUpdate()
    {
        $orderModel = new Orders();
        $mesg = "Test order message";
        $initialStatus = "pending";

        $orderModel->insertOrder($this->boid, $this->supplieruserid, $mesg, $initialStatus);
        $query = $this->db->query("SELECT orderid FROM orders ORDER BY orderid DESC LIMIT 1");
        $row = $this->db->fetchRow($query);
        $orderId = $row['orderid'];

        $newStatus = "completed";
        $result = $orderModel->updateOrderStatus($orderId, $newStatus);
        $this->assertTrue($result);

        $query = $this->db->query("SELECT * FROM orders WHERE orderid='$orderId'");
        $updatedRow = $this->db->fetchRow($query);
        $this->assertEquals($newStatus, $updatedRow['status']);
    }
}
?> 