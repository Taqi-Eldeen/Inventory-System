<?php
include_once 'sidebarowner.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Supply</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/managesupply.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="container-fluid fade-in">
                <h1 class="my-4">Manage Supply</h1>
                
                <!-- Add Supply Section -->
                <section class="add-supply mb-4">
                    <h2>Add New Supply</h2>
                    <form action="add_supply.php" method="post">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="supplyName" class="form-label">Supply Name:</label>
                                <input type="text" id="supplyName" name="supplyName" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="number" id="quantity" name="quantity" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="supplier" class="form-label">Supplier:</label>
                                <input type="text" id="supplier" name="supplier" class="form-control" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Add Supply</button>
                    </form>
                </section>
                
                <!-- View Supplies Section -->
                <section class="view-supplies">
                    <h2>Existing Supplies</h2>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Supply ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Supplier</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <tr>
                                    <td>1</td>
                                    <td>Item A</td>
                                    <td>100</td>
                                    <td>Supplier X</td>
                                    <td>
                                        <form action="delete_supply.php" method="post" onsubmit="return confirm('Are you sure you want to delete this supply?');">
                                            <input type="hidden" name="supplyId" value="1">
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