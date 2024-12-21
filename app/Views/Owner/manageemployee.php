<?php
require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../Model/Users.php");

// Initialize userController
$userController = new UsersController();

// Handle form submission for adding new employee
if (isset($_POST['adduser'])) {
    $userController->insert();
}

// Handle form submission for update and delete actions
if (isset($_POST['update_employee'])) {
    $userController->edit(); // Edit an existing employee
}

if (isset($_POST['delete_employee'])) {
    $userController->delete($_POST['delete_id']); // Delete an employee
}

$boid = $_SESSION['boid'];

// Fetch the employees associated with the BOid
$employees = $userController->getEmployeeByBOid($boid);
?>

<?php include '../User/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/manageemployee.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="container-fluid fade-in">
                <h1 class="my-4">Manage Employee</h1>
                
                <!-- Add Employee Section -->
                <section class="add-employee mb-4">
                    <h2>Add New Employee</h2>
                    <form action="manageemployee.php" method="post">
                        <div class="row">
                            <!-- Name Input -->
                            <div class="col-md-4 mb-3">
                                <label for="username" class="form-label">Employee Name:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            
                            <!-- Email Input -->
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            
                            <!-- Password Input -->
                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                        </div>

                        <input type="hidden" name="type" value="2">  <!-- 2 represents Employee -->
                        <input type="hidden" name="boid" value="<?php echo $_SESSION['boid']; ?>">

                        <button type="submit" class="btn btn-success" name="adduser">Add Employee</button>
                    </form>
                </section>
                
                <!-- View Employees Section -->
                <section class="view-employees">
                    <h2>Existing Employees</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($employees)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No employees found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($employees as $employee): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($employee['id']); ?></td>
                                            <td><?php echo htmlspecialchars($employee['username']); ?></td>
                                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                                            <td>
                                                <!-- Edit Employee -->
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                    data-id="<?php echo $employee['id']; ?>"
                                                    data-username="<?php echo htmlspecialchars($employee['username']); ?>"
                                                    data-email="<?php echo htmlspecialchars($employee['email']); ?>"
                                                >Edit</button>
                                                
                                                <!-- Delete Employee -->
                                                <form action="manageemployee.php" method="POST" style="display:inline;">
                                                    <input type="hidden" name="delete_id" value="<?php echo $employee['id']; ?>">
                                                    <button type="submit" name="delete_employee" class="btn btn-danger btn-sm">Delete</button>
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
        </main>
    </div>

    <!-- Modal for Edit Employee -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="manageemployee.php">
                        <input type="hidden" id="employee_id" name="id">
                        <div class="mb-3">
                            <label for="username" class="form-label">Employee Name:</label>
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
                        <button type="submit" name="update_employee" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script>
        // Populate the edit modal with the selected employee's data
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var employeeID = button.data('id');
            var username = button.data('username');
            var email = button.data('email');

            var modal = $(this);
            modal.find('#employee_id').val(employeeID);
            modal.find('#username').val(username);
            modal.find('#email').val(email);
        });
    </script>
</body>
</html>
