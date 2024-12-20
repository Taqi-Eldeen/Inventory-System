<?php
include_once 'sidebarowner.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employees</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/manageemployee.css">
</head>
<body>
    <div class="dashboard">
        <main class="main-content">
            <div class="container-fluid fade-in">
                <h1 class="my-4">Manage Employees</h1>
                
                <!-- Add Employee Section -->
                <section class="add-employee mb-4">
                    <h2>Add New Employee</h2>
                    <form action="add_employee.php" method="post">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="employeeName" class="form-label">Employee Name:</label>
                                <input type="text" id="employeeName" name="employeeName" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="position" class="form-label">Position:</label>
                                <input type="text" id="position" name="position" class="form-control" required>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone Number:</label>
                                <input type="tel" id="phone" name="phone" class="form-control" required>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-success">Add Employee</button>
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
                                    <th>Position</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Example Row -->
                                <tr>
                                    <td>101</td>
                                    <td>John Doe</td>
                                    <td>johndoe@example.com</td>
                                    <td>Manager</td>
                                    <td>123-456-7890</td>
                                    <td>
                                        <a href="edit_employee.php?id=101" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="delete_employee.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                            <input type="hidden" name="employeeId" value="101">
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