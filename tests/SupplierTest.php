<?php
require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
require_once(dirname(__FILE__, 2) . '/app/Model/Users.php');  
use PHPUnit\Framework\TestCase;

class SupplierTest extends TestCase
{
    protected $db;

    protected function setUp(): void
    {
        $this->db = DatabaseHandler::getInstance();
        $this->db->setTestDB();
        
        $this->db->query("TRUNCATE TABLE supplier");
    }

    protected function tearDown(): void
    {
        $this->db->resetDBConnection();
    }

    public function testInsertSupplier()
    {
        $username = "johnDoeBusiness";
        $email = "john@mail.com";
        $password = "pass1234@";

        $usersModal = new Users();
        $usersModal->signUpBusinessOwner($username, $email, $password);
        $query = $this->db->query("Select * FROM user WHERE username='$username'");
        $row = $this->db->fetchRow($query);

        $userid = $row["id"];

        $query = $this->db->query("Select * FROM bowner WHERE userid = $userid");
        $row = $this->db->fetchRow($query);

        $this->assertEquals($userid, $row["userid"], "Bowner entry should exist");

        $boid = $row["boid"];

        $username = "smith";
        $email = "smith@mail.com";
        $password = "pass1234@";
        $type = 1;

        $usersModal->insertUserbo($username, $email, $password, $type, $boid);
        $query = $this->db->query("Select * FROM user WHERE username='smith'");
        $row = $this->db->fetchRow($query);

        $this->assertEquals($username, $row["username"]);
        $this->assertTrue(password_verify($password, $row["password"]));
        $this->assertEquals($email, $row["email"]);
        $this->assertEquals(1, $row["type"]);

        $userid = $row["id"];

        $query = $this->db->query("Select * FROM supplier WHERE boid=$boid");
        $row = $this->db->fetchRow($query);

        $this->assertEquals($userid, $row["userid"]);
    }

}
?> 