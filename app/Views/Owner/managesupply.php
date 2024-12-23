<?php
require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../Model/Users.php");

$userController = new UsersController();

if (isset($_POST['adduser'])) {
    $userController->insertBO();
}
if (isset($_POST['update_supplier'])) {
    $userController->edit(); 
}
if (isset($_POST['delete_supplier'])) {
    $userController->delete($_POST['delete_id']);
}

$boid = $_SESSION['boid'];
$suppliers = $userController->getSuppliersByBOid($boid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Supplier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/managesupply.css">



</head>
<body>
    <?php include '../User/sidebar.php'; ?>

    <div class="main-content">
    <div class="container mt-4">
        <h1 class="mb-4 text-start">Manage Supplier</h1>

        <section class="mb-4">
            <h2 class="text-start">Add New Supplier</h2>
            <form action="managesupply.php" method="post" class="row g-3">
                <div class="col-md-4">
                    <label for="username" class="form-label">Supplier Name:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <input type="hidden" name="type" value="1">
                <input type="hidden" name="boid" value="<?php echo $_SESSION['boid']; ?>">
                <div class="col-12">
                    <button type="submit" class="btn btn-success" name="adduser">Add Supplier</button>
                </div>
            </form>
        </section>

        <section>
            <h2 class="text-start">Existing Suppliers</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Supplier ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($suppliers)): ?>
                            <tr>
                                <td colspan="4" class="text-center">No suppliers found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($suppliers as $supplier): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($supplier['id']); ?></td>
                                    <td><?php echo htmlspecialchars($supplier['username']); ?></td>
                                    <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                                    <td>
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                                            data-id="<?php echo $supplier['id']; ?>"
                                            data-username="<?php echo htmlspecialchars($supplier['username']); ?>"
                                            data-email="<?php echo htmlspecialchars($supplier['email']); ?>"
                                        >Edit</button>
                                        <form action="managesupply.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="delete_id" value="<?php echo $supplier['id']; ?>">
                                            <button type="submit" name="delete_supplier" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="managesupply.php">
                        <input type="hidden" id="supplier_id" name="id">
                        <div class="mb-3">
                            <label for="username" class="form-label">Supplier Name:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="form-text text-muted">Leave blank if you don't want to change the password.</small>
                        </div>
                        <button type="submit" name="update_supplier" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var supplierID = button.data('id');
            var username = button.data('username');
            var email = button.data('email');

            var modal = $(this);
            modal.find('#supplier_id').val(supplierID);
            modal.find('#username').val(username);
            modal.find('#email').val(email);
        });
    </script>
</body>
</html>
