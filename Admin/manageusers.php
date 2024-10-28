<?php
include "../DBConnection.php";
include "../userClass.php";

// Create a database connection
$db = $conn; // Use the existing connection from DBConnection.php

// Initialize the Users class with the database connection
$users = new Users($db);
$allUsers = $users->listUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="manageusers.css">

    <!-- Load jQuery, Bootstrap, and DataTables JS libraries -->
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
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <button class="edit-btn" data-id="<?php echo $user['id']; ?>">Edit</button>
                        <button class="delete-btn" data-id="<?php echo $user['id']; ?>">Delete</button>
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

<!-- Initialize DataTable after DOM is loaded -->
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            paging: true,  // Enable pagination
            searching: true, // Enable the search bar
        });
    });
</script>

</body>
</html>
