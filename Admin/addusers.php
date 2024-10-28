<?php
   include "../DBConnection.php"; // Include your database connection
   include "../userClass.php"; // Include your user class

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
         
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $userTypeID = intval($_POST['role']); 
            
            
        
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            // Call the Insert function to add the user
            if (User::InsertinDB_Static($username, $hashedPassword, $email, $userTypeID)) {
                echo "<script>alert('User added successfully.');</script>";
            } else {
                echo "<script>alert('Error adding user.');</script>";
            }
        }
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="addusers.css">
</head>
<body>
<?php require 'sidebaradmin.php'; ?>

<div class="main-content"> 
    <div class="container">
        <h1>Add New User</h1>
        <form action="addusers.php" method="POST"> <!-- Form submission -->
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
                    <option value="1">Supplier</option> <!-- Assuming '2' is the ID for User -->
                    <option value="0">Admin</option> <!-- Assuming '1' is the ID for Admin -->
                </select>
            </div>
            <button type="submit">Add User</button>
        </form>

    
    </div>
</div>
</body>
</html>
