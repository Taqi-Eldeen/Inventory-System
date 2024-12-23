<?php

require_once('config.php'); 


if (!class_exists('DatabaseHandler')) {
    class DatabaseHandler {
        private static $instance = null; 
        public $servername;
        private $username;
        private $password;
        private $dbname;
        private $conn;

        
        private function __construct() {
            $this->servername = DB_SERVER;
            $this->username = DB_USER;
            $this->password = DB_PASS;
            $this->dbname = DB_DATABASE;
            $this->connect();
        }

        public function setTestDB() {
            $this->conn->close();
            $this->dbname = DB_TEST;
            $this->connect();
        }

        public function resetDBConnection() {
            $this->conn->close();
            $this->dbname = DB_DATABASE;
            $this->connect();
        }
        
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }

        public function connect() {
            
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            return $this->conn;
        }

        
        public function getConn() {
            return $this->conn;
        }

        
        public function query($sql) {
            if (!empty($sql)) {
                return $this->conn->query($sql);
            }
            return false;
        }

        
        public function prepare($sql) {
            return $this->conn->prepare($sql);
        }

        public function fetchRow($result = "") {
            if (empty($result)) { 
                $result = $this->result; 
            }
            return $result->fetch_assoc();
        }

        public function real_escape_string($value) {
            return $this->conn->real_escape_string($value);
        }

        
        public function getInsertId() {
            return $this->conn->insert_id;
        }

        
        public function begin_transaction() {
            $this->conn->begin_transaction();
        }

        
        public function commit() {
            $this->conn->commit();
        }

        
        public function rollback() {
            $this->conn->rollback();
        }
        function __destruct() {
            $this->conn->close();
        }
    }
}
?>
