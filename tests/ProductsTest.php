<?php
require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/Products.php');  
use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
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
    }

    protected function tearDown(): void
    {
        $this->db->resetDBConnection();
    }

    public function testInsertProduct()
    {
        $productsModel = new Products();
        $result = $productsModel->insertProduct('Test Product', 100, 10, 1, 1);

        $this->assertTrue($result);

        $query = $this->db->query("SELECT * FROM product WHERE name='Test Product'");
        $row = $this->db->fetchRow($query);
        $this->assertNotEmpty($row);
        $this->assertEquals('Test Product', $row['name']);
    }
}
?> 