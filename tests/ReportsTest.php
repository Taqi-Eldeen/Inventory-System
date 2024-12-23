<?php
require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/Report.php');  
use PHPUnit\Framework\TestCase;

class ReportsTest extends TestCase
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

    public function testInsertReport()
    {
        $empid = 1; // Assuming a valid employee ID exists
        $mesg = "Test report message";

        $reportsModel = new Reports();
        $result = $reportsModel->insertReport($empid, $mesg);

        $this->assertTrue($result);

        $query = $this->db->query("SELECT * FROM report WHERE mesg='$mesg'");
        $row = $this->db->fetchRow($query);
        $this->assertNotEmpty($row);
        $this->assertEquals($mesg, $row['mesg']);
    }
}
?> 