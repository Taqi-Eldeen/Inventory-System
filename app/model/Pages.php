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

    // function insertProduct($name, $price, $qty, $userid) {
    //     // Step 1: Fetch supplierid based on userid
    //     $getSupplierIdSql = "SELECT supplierid FROM supplier WHERE userid = ?";
    //     $stmt = $this->db->prepare($getSupplierIdSql);
    //     $stmt->bind_param("i", $userid);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     if ($result->num_rows === 0) {
    //         // If no supplierid exists for the given userid, show an error
    //         echo "ERROR: No supplier found with User ID $userid.";
    //         return;
    //     }
    
    //     // Fetch the supplierid
    //     $row = $result->fetch_assoc();
    //     $supplierid = $row['supplierid'];
    
    //     // Step 2: Insert the product using the dynamically fetched supplierid
    //     $insertProductSql = "INSERT INTO product (name, price, qty, supplierid) VALUES (?, ?, ?, ?)";
    //     $stmt = $this->db->prepare($insertProductSql);
    //     $stmt->bind_param("siii", $name, $price, $qty, $supplierid);
    
    //     if ($stmt->execute()) {
    //         echo "Product inserted successfully with Supplier ID $supplierid.";
    //         $this->fillArray(); // Refresh the products array
    //     } else {
    //         echo "ERROR: Could not insert product. " . $this->db->error;
    //     }
    // }
    
    
    
    // Delete a product by ID
    // function deleteProduct($id) {
    //     $sql = "DELETE FROM product WHERE id = " . intval($id);

    //     if ($this->db->query($sql) === true) {
    //         echo "Product deleted successfully.";
    //         $this->fillArray(); // Refresh the products array
    //     } else {
    //         echo "ERROR: Could not execute $sql. " . $this->db->error;
    //     }
    // }

    // Update an existing product
    // function updateProduct($id, $name, $price, $qty, $supplierid) {
    //     $sql = "UPDATE product SET 
    //                 name = '$name', 
    //                 price = '$price', 
    //                 qty = '$qty', 
    //                 supplierid = '$supplierid'
    //             WHERE id = " . intval($id);

    //     if ($this->db->query($sql) === true) {
    //         echo "Product updated successfully.";
    //         $this->fillArray(); // Refresh the products array
    //     } else {
    //         echo "ERROR: Could not execute $sql. " . $this->db->error;
    //     }
    // }
    // public static function SelectAllProductsInDB() {
    //     $db = new DatabaseHandler(); // Use DBh to get a connection
    //     $sql = "SELECT * FROM product";
    //     return $db->query($sql);
    // }

//  public static function SelectProductsBySupplier($supplierID) {
//     $db = new DatabaseHandler();
//     $sql = "SELECT * FROM product WHERE supplierid = " . intval($supplierID);
//     $result = $db->query($sql);

//     if ($result) {
//         $products = [];
//         if ($result->num_rows > 0) {  // Check if there are rows in the result
//             while ($row = $result->fetch_assoc()) {
//                 $products[] = $row; // Add each product to the array
//             }
//         } else {
//             // If no rows are returned
//             echo "No products found for this supplier.";
//         }

//         return $products;
//     } else {
//         echo "ERROR: Could not retrieve products.";
//         return []; // Return an empty array if no products are found
//     }
}

// }
?>