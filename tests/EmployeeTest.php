<?php
    require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
    require_once(dirname(__FILE__, 2) . '/app/Model/Users.php');  
    use PHPUnit\Framework\TestCase;

class EmployeeTest extends TestCase
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
    
    public function testUserCreation()
    {            
        $username = "johnDoe";
        $email = "john@mail.com";
        $password = "pass1234@";
        $type = 2;

        $usersModal = new Users();
        $usersModal->insertUserbo($username, $email, $password, $type);
        $query = $this->db->query("Select * FROM user WHERE username='$username'");
        $row = $this->db->fetchRow($query);

        $this->assertEquals('johnDoe', $row["username"]);
        $this->assertTrue(password_verify($password, $row["password"]));
        $this->assertEquals('john@mail.com', $row["email"]);
        $this->assertEquals(2, $row["type"]);
    }
}
?>