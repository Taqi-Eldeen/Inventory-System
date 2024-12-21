<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__FILE__) . '/../config/DBConnection.php');

abstract class Model{
    protected $db;
    protected $conn;

    public function connect(){
        if(null === $this->conn ){
            $this->db = DatabaseHandler::getInstance();
        }
        return $this->db;
    }
}
?>