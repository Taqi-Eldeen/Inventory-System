<?php
// Include the Controller and Model files using relative paths
require_once(dirname(__FILE__) . '/../Model/Users.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class UsersController extends Controller {

    // Constructor to pass the model to the parent Controller
    public function __construct() {
        $model = new Users(); // Instantiate the Users model
        parent::__construct($model); // Pass the model to the parent constructor
    }

    // Insert a new user
// Insert a new user
public function insert() {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type']; // 'type' is being used here

    if (!empty($username) && !empty($email) && !empty($password) && !empty($type)) {
        $this->model->insertUser($username, $email, $password, $type);
    } else {
        echo "All fields are required to insert a user.";
    }
}



    // Edit an existing user
    public function edit() {
        $id = $_REQUEST['id'];
        $username = $_REQUEST['username'];
        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];

        if (!empty($id) && !empty($username) && !empty($email) && !empty($password)) {
            $this->model->updateUser($id, $username, $email, $password);
        } else {
            echo "All fields are required to edit a user.";
        }
    }

    // Delete a user by ID
    public function delete($id) {
        if (!empty($id)) {
            $this->model->deleteUser($id);
            echo "User deleted successfully.";
        } else {
            echo "User ID is required to delete a user.";
        }
    }

    public function getUsers() {
        // Fetch all users from the model
        return $this->model->getUsers(); // or model->getAllUsers()
    }
}
?>