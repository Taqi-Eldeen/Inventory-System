<?php
require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/Users.php');  
use PHPUnit\Framework\TestCase;

class AdminTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        $this->db = DatabaseHandler::getInstance();
        $this->db->setTestDB();
        
        // Truncate tables to ensure a clean state for each test
        $this->db->query("TRUNCATE TABLE user");
    }

    protected function tearDown(): void
    {
        $this->db->resetDBConnection();
    }

    public function testInsertAdminUser()
    {
        $username = "admin";
        $email = "admin@mail.com";
        $password = "pass1234@";
        $type = 0;

        $usersModal = new Users();
        $usersModal->insertUserbo($username, $email, $password, $type);
        $query = $this->db->query("Select * FROM user WHERE username='$username'");
        $row = $this->db->fetchRow($query);

        $this->assertEquals('admin', $row["username"]);
        $this->assertTrue(password_verify($password, $row["password"]));
        $this->assertEquals('admin@mail.com', $row["email"]);
        $this->assertEquals(0, $row["type"]);

    }
}
?> 