<?php
include "../DBConnection.php";
include "../userClass.php"; 

// Handle delete request
if (isset($_POST['delete_id'])) {
    $userID = intval($_POST['delete_id']); // Get the user ID from the POST request

    // Create an object to pass to the delete method
    $objUser = new stdClass();
    $objUser->ID = $userID;

    // Call the delete method
    if (User::deleteUser($objUser)) {
        echo "<script>alert('User deleted successfully.');</script>";
        // Redirect to refresh the page
        header("Location: manageusers.php");
        exit();
    } else {
        echo "<script>alert('Error deleting user.');</script>";
    }
}

// Handle update request
if (isset($_POST['update_user'])) {
    $userID = intval($_POST['user_id']);
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // Get the password from the form

    // Create a User object and update details
    $objUser = new User($userID);
    $objUser->username = $username;
    $objUser->email = $email;

    // If a new password is provided, update it in the user object
    if (!empty($password)) {
        $objUser->password = $password; // Ensure your User class can handle password updates
    }

    if ($objUser->UpdateMyDB()) {
        echo "<script>alert('User updated successfully.');</script>";
        header("Location: manageusers.php");
        exit();
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}

$allUsers = User::SelectAllUsersInDB();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="manageusers.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
    <title>Manage Users</title>
</head>
<body>
    
<?php require 'sidebaradmin.php'; ?>

<div class="main-content"> 
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($allUsers as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user->ID); ?></td>
                    <td><?php echo htmlspecialchars($user->username); ?></td>
                    <td><?php echo htmlspecialchars($user->email); ?></td>
                    <td>
                        <button class="edit-btn btn btn-warning" 
                                data-id="<?php echo $user->ID; ?>" 
                                data-username="<?php echo htmlspecialchars($user->username); ?>" 
                                data-email="<?php echo htmlspecialchars($user->email); ?>" 
                                data-password="<?php echo htmlspecialchars($user->password); ?>" 
                                data-toggle="modal" 
                                data-target="#myModal">Edit</button>
                        <form action="manageusers.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $user->ID; ?>">
                            <button type="submit" class="delete-btn btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>User ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </tfoot>
    </table>
</div>

<!-- Edit User Modal -->
<div class="modal" id="myModal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Edit User</h2>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <!-- Form for editing user details -->
            <form id="editUserForm" method="POST" action="manageusers.php">
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="text" name="password" id="password" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_user" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Initialize DataTable after DOM is loaded -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            paging: false,
            searching: true,
        });

        // Handle edit button click
        $('.edit-btn').on('click', function() {
            const userID = $(this).data('id');
            const username = $(this).data('username');
            const email = $(this).data('email');
            const password = $(this).data('password'); // Ensure you have this data attribute if you want to pass it
            
            console.log("User ID:", userID);
            console.log("Username:", username);
            console.log("Email:", email);
            console.log("Password:", password); // Log the password to check if it’s being retrieved

            $('#user_id').val(userID);
            $('#username').val(username);
            $('#email').val(email);
            $('#password').val(password); // Ensure this line is correct
            
            // Show the modal
            $('#myModal').modal('show');
        });
    });

    function closeModal() {
        $('#myModal').modal('hide');
    }
</script>

</body>
</html>
