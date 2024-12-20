<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Page extends Model {
	public $id;
	public $pageName;
	public $title;
	public $roleId;

    function __construct($id = null, $pageName = "", $title = "", $roleId = "") {
		$this->id = $id;
		$this->pageName = $pageName;
		$this->title = $title;
		$this->roleId = $roleId;
    }

    // Fetch Product Details
    function readPage($id) {
        if (!empty($id)) {
            $sql = "SELECT * FROM pages WHERE id = " . intval($id); // Prevent SQL injection using intval
            $result = $this->db->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
				$this->pageName = $row["page_name"];
				$this->title = $row["title"];
				$this->roleId = $row["role_id"];
            } else {
                // If no product is found, set default values
				$this->pageName = $pageName;
				$this->title = $title;
				$this->roleId = $roleId;
            }
        } else {
            echo "Page ID is required!";
        }
    }

}
?>
