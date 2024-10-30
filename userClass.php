<?php
include "DBConnection.php";

class User{
    public $ID;
    public $username;
    public $email;
    public $password;
    public $type;

    function __construct($id)	{
		if ($id !=""){
			$sql="select * from user where id=$id";
			$User = mysqli_query($GLOBALS['conn'],$sql);
			if ($row = mysqli_fetch_array($User)){
				$this->username=$row["username"];
                $this->email=$row["email"];
				$this->password=$row["password"];
				$this->ID=$row["id"];
                $this->type=$row["type"];
			}
		}
	}
    static function InsertinDB_Static($UN, $PW, $email, $userTypeID) {
      
        $sql = "INSERT INTO user (username, password, email, type) VALUES ('$UN', '$PW', '$email', '$userTypeID')";

        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true;
        } else {
            
            return false;
        }
    }

    
    static function SelectAllUsersInDB() {
  
        $sql = "SELECT * FROM user";
        $Users = mysqli_query($GLOBALS['conn'], $sql);
    
        if (!$Users) {
            die("Query failed: " . mysqli_error($conn)); 
        }
    
        $Result = []; 
        $i = 0;
    
        while ($row = mysqli_fetch_array($Users)) { 
            $MyObj = new User($row["id"]); 
            $Result[$i] = $MyObj;
            $i++;
        }
    
        return $Result; 
    }
    function UpdateMyDB(){
        $sql = "UPDATE user SET username='" . $this->username . "', password='" . $this->password . "', email='" . $this->email . "' WHERE ID=" . intval($this->ID);

        if (mysqli_query($GLOBALS['conn'], $sql)) {
            return true;
        } else {
            return false;
        }
    }
    static function deleteUser($ObjUser){
		$sql="delete from user where id=".$ObjUser->ID;
		if(mysqli_query($GLOBALS['conn'],$sql))
			return true;
		else
			return false;
	}

}