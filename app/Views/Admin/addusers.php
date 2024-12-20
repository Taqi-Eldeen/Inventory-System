<?php
// Include the necessary controller and model files
require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../model/Users.php");

// Function to validate password complexity
function validatePassword($password) {
    return strlen($password) >= 8 && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}

// Create an instance of the UserController
$userController = new UsersController();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the insert method from UserController
    $userController->insert();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="../../../public/css/addusers.css">
</head>
<body>
<?php include '../User/sidebar.php'; ?>

<div class="main-content"> 
    <h2>Add Users</h2>
    <div class="container">
        <h1>Add New User</h1>
        <!-- Display success or error message based on the form submission -->
        <?php if (!empty($errorMessage)): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <!-- The form for adding a new user -->
        <form action="addusers.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
    <label for="role">Role:</label>
    <select id="role" name="type" required> <!-- change 'role' to 'type' -->
        <option value="2">User</option>
        <option value="1">Supplier</option>
        <option value="0">Admin</option>
    </select>
</div>
>
            <button type="submit">Add User</button>
        </form>
    </div>
</div>
</body>
</html>
