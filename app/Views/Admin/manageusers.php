<?php
// Including necessary files
require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../Model/Users.php");

// Create an instance of the UsersController
$controller = new UsersController();

// Handle update and delete actions based on POST requests
if (isset($_POST['update_user'])) {
    $controller->edit(); // Edit an existing user
}

if (isset($_POST['delete_user'])) {
    $controller->delete($_POST['delete_id']); // Delete a user
}

// Fetch all users again to ensure the latest data is loaded
$allUsers = $controller->getUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <title>Manage Users</title>
</head>
<body>

<?php include '../User/sidebar.php'; ?>

<div class="main-content">
    
    <!-- Users Table -->
    <table class="table table-striped">
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
                    <td><?php echo htmlspecialchars($user->getID()); ?></td>
                    <td><?php echo htmlspecialchars($user->getUsername()); ?></td>
                    <td><?php echo htmlspecialchars($user->getEmail()); ?></td>
                    <td>
                        <!-- Edit User -->
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                            data-id="<?php echo $user->getID(); ?>"
                            data-username="<?php echo htmlspecialchars($user->getUsername()); ?>"
                            data-email="<?php echo htmlspecialchars($user->getEmail()); ?>"
                            data-type="<?php echo $user->getType(); ?>"
                        >Edit</button>
                        
                        <!-- Delete User -->
                        <form action="manageusers.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $user->getID(); ?>">
                            <button type="submit" name="delete_user" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Edit User -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="manageusers.php">
                    <input type="hidden" id="user_id" name="id">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>               
                    <button type="submit" name="update_user" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Populate the edit modal with the selected user's data
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var userID = button.data('id');
        var username = button.data('username');
        var email = button.data('email');
        var type = button.data('type');

        var modal = $(this);
        modal.find('#user_id').val(userID);
        modal.find('#username').val(username);
        modal.find('#email').val(email);
        modal.find('#type').val(type);
    });
</script>

</body>
</html>
