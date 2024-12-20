<?php

require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../model/Users.php");

// Initialize userController
$userController = new UsersController();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get BOid from session
   

    // Pass the BOid as part of the form submission
    $userController->insertBO();
}
?>

<?php include_once 'sidebarowner.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Supplier</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/managesupply.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="container-fluid fade-in">
                <h1 class="my-4">Manage Supplier</h1>
                
                <!-- Add Supplier Section -->
                <section class="add-supplier mb-4">
                    <h2>Add New Supplier</h2>
                    <form action="managesupply.php" method="post">
                        <div class="row">
                            <!-- Name Input -->
                            <div class="col-md-4 mb-3">
                                <label for="username" class="form-label">Supplier Name:</label>
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

                        <!-- Hidden Input for Supplier Type -->
                        <input type="hidden" name="type" value="1">  <!-- 1 represents Supplier -->
                        
                        <!-- Hidden Input for Business Owner ID (BOid) -->
                        <input type="hidden" name="boid" value="<?php echo $_SESSION['boid']; ?>"> <!-- BOid from session -->

                        <button type="submit" class="btn btn-success">Add Supplier</button>
                    </form>
                </section>
                
                <!-- View Suppliers Section -->
                <section class="view-suppliers">
                    <h2>Existing Suppliers</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Supplier ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <tr>
                                    <td>1</td>
                                    <td>Supplier X</td>
                                    <td>supplierx@example.com</td>
                                    <td>
                                        <form action="delete_supplier.php" method="post" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                            <input type="hidden" name="supplierId" value="1">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <!-- More rows will be populated here dynamically -->
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html>
