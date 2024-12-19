<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Employees</title>
    <link rel="stylesheet" href="../../../public/css/manageemployee.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Owner Dashboard</h2>
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <li><a href="managesupply.html">Manage Supply</a></li>
                <li><a href="manage_employee.html" class="active">Manage Employees</a></li>
                <li><a href="manageusers.html">Manage Users</a></li>
                <li><a href="reports.html">Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <h1>Manage Employees</h1>
            
            <!-- Add Employee Section -->
            <section class="add-employee">
                <h2>Add New Employee</h2>
                <form action="add_employee.php" method="post">
                    <label for="employeeName">Employee Name:</label>
                    <input type="text" id="employeeName" name="employeeName" required>
                    
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    
                    <label for="position">Position:</label>
                    <input type="text" id="position" name="position" required>
                    
                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>
                    
                    <button type="submit">Add Employee</button>
                </form>
            </section>
            
            <!-- View Employees Section -->
            <section class="view-employees">
                <h2>Existing Employees</h2>
                <table>
                    <thead>
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
                                <a href="edit_employee.php?id=101">Edit</a> |
                                <form action="delete_employee.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                    <input type="hidden" name="employeeId" value="101">
                                    <button type="submit">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <!-- More rows will be populated here dynamically -->
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>