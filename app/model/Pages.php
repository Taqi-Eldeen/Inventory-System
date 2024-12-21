<?php
require_once(dirname(__FILE__) . '/../model/Model.php');
require_once(dirname(__FILE__) . '/../model/Page.php');

class Pages extends Model {
    public $pages;

    function __construct($roleId) {
        $this->pages = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray($roleId);
    }

    // Populate the products array
    function fillArray($roleId) {
        $this->pages = [];
        $result = $this->readPagesByRole($roleId);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $page = new Page(
                    $row["id"], 
                    $row["page_name"],
                    $row["title"],
                    $row["role_id"]
                );
                array_push($this->pages, $page);
            }
        }
    }

    // Fetch all products from the database
    function readPages() {
        $sql = "SELECT * FROM pages ORDER BY title DESC";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    function readPagesByRole($roleId) {
        $sql = "SELECT * FROM pages WHERE role_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $roleId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }
}
?>