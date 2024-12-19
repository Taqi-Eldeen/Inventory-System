<?php
// Include the configuration file to access database constants
require_once('config.php'); // Adjust the path as necessary

// Check if the class already exists to avoid redeclaration
if (!class_exists('DatabaseHandler')) {
    class DatabaseHandler {
        private $servername;
        private $username;
        private $password;
        private $dbname;
        private $conn;

        public function __construct() {
            // Use the constants from config.php
            $this->servername = DB_SERVER;
            $this->username = DB_USER;
            $this->password = DB_PASS;
            $this->dbname = DB_DATABASE;

            $this->connect();
        }

        public function connect() {
            // Establish a database connection
            $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            return $this->conn;
        }

        // Return the mysqli connection to use prepare() and other methods
        public function getConn() {
            return $this->conn;
        }

        // Query execution method (for normal queries)
        public function query($sql) {
            if (!empty($sql)) {
                return $this->conn->query($sql);
            }
            return false;
        }

        // Prepared statement method (allows usage of prepare())
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

        // Method to retrieve the last inserted ID
        public function getInsertId() {
            return $this->conn->insert_id;
        }

        // Begin a transaction
        public function begin_transaction() {
            $this->conn->begin_transaction();
        }

        // Commit the transaction
        public function commit() {
            $this->conn->commit();
        }

        // Rollback the transaction
        public function rollback() {
            $this->conn->rollback();
        }

        function __destruct() {
            $this->conn->close();
        }
    }
}
?>
