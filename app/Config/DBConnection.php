<?php

require_once("config.php");

class DBh {
    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $conn;
    private $result;
    public $sql;

    function __construct() {
        $this->servername = DB_SERVER;
        $this->username = DB_USER;
        $this->password = DB_PASS;
        $this->dbname = DB_DATABASE;
        $this->connect();
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
        if (!empty($sql)){
            $this->sql = $sql;
            $this->result = $this->conn->query($sql);
            return $this->result;
        } else {
            return false;
        }
    }

    public function fetchRow($result="") {
        if (empty($result)){ 
            $result = $this->result; 
        }
        return $result->fetch_assoc();
    }

    // Add the real_escape_string method
    public function real_escape_string($value) {
        return $this->conn->real_escape_string($value);
    }

    function __destruct() {
        $this->conn->close();
    }
}
?>
