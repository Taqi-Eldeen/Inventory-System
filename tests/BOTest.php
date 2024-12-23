<?php
    require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
    require_once(dirname(__FILE__, 2) . '/app/Model/Users.php');  
    use PHPUnit\Framework\TestCase;

    class BOTest extends TestCase
    {
        public static $db;
        protected function setUp(): void
        {
            // $this->db = new mysqli(DB_SERVER, DB_USER, DB_PASS, 'test_db');
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

        public function testBusinessOwnerCreation()
        {
            $username = "johnDoeBusiness";
            $email = "john@mail.com";
            $password = "pass1234@";

            $usersModal = new Users();
            $usersModal->signUpBusinessOwner($username, $email, $password);
            $query = $this->db->query("Select * FROM user WHERE username='$username'");
            $row = $this->db->fetchRow($query);

            $this->assertEquals($username, $row["username"]);
            $this->assertTrue(password_verify($password, $row["password"]));
            $this->assertEquals($email, $row["email"]);
            $this->assertEquals(3, $row["type"]);

            $userid = $row["id"];

            $query = $this->db->query("Select * FROM bowner WHERE userid = $userid");
            $row = $this->db->fetchRow($query);

            $this->assertEquals($userid, $row["userid"], "Bowner entry should exist");
        }
    }
?>