<?php
include "../../config/DBConnection.php"; 
include "../../Controllers/userClass.php"; 


function validatePassword($password) {
  
    return strlen($password) >= 8 && preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}


$errorMessage = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $userTypeID = intval($_POST['role']);
    

    if (validatePassword($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   
        if (User::InsertinDB_Static($username, $hashedPassword, $email, $userTypeID)) {
            $successMessage = "User added successfully.";
        } else {
            $errorMessage = "Error adding user.";
        }
    } else {
        $errorMessage = "Password must be at least 8 characters long and contain at least one special character.";
    }
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
<?php require 'sidebaradmin.php'; ?>

<div class="main-content"> 
<H2>Add Users</H2>
    <div class="container">
        <h1>Add New User</h1>
        <?php if (!empty($errorMessage)): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php endif; ?>
        <?php if (!empty($successMessage)): ?>
            <p class="success"><?php echo $successMessage; ?></p>
        <?php endif; ?>
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
                <select id="role" name="role" required>
                    <option value="2">User</option>
                    <option value="1">Supplier</option>
                    <option value="0">Admin</option>
                </select>
            </div>
            <button type="submit">Add User</button>
        </form>
    </div>
</div>
</body>
</html>
