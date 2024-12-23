<?php 
    require_once(dirname(__FILE__, 2) . '/app/Config/DBConnection.php');  
    use PHPUnit\Framework\TestCase;


    final class UserCreation extends TestCase
    {
        protected $db;
        protected function setUp(): void
        {
            // $this->db = new mysqli(DB_SERVER, DB_USER, DB_PASS, 'test_db');
            $this->$db = DatabaseHandler::getInstance();
            $this->$db->setTestDB();
            print($this->$db->dbname);
            
            $this->db->query("TRUNCATE TABLE bowner");
            $this->db->query("TRUNCATE TABLE employee");
            $this->db->query("TRUNCATE TABLE inventory");
            $this->db->query("TRUNCATE TABLE pages");
            $this->db->query("TRUNCATE TABLE product");
            $this->db->query("TRUNCATE TABLE supplier");
            $this->db->query("TRUNCATE TABLE user");
            $this->db->query("TRUNCATE TABLE report");
            $this->db->query("TRUNCATE TABLE order");
        }
    
        protected function tearDown(): void
        {
            $this->db->resetDBConnection();
        }

        public function testUserCreate()
        {
            $username = "johnDoe";
            $email = "john@mail.com";
            $password = "pass1234@";
            $type = 2;

            $usersModal = new Users();
            $usersModal->insertUserbo($username, $email, $password, $type);
            $query = $this->db->query("Select * FROM user WHERE username = $username");
            $row = $this->db->fetchRow($query);

            $this->assetEquals('johnDoe', $row["name"]);
            $this->assetEquals('pass1234@', $row["password"]);
            $this->assetEquals('john@mail.com', $row["email"]);
            $this->assetEquals(2, $row["type"]);
        }
    }
?>