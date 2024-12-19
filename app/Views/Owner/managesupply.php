<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Supply</title>
    <link rel="stylesheet" href="css/managesupply.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <h2>Owner Dashboard</h2>
            <ul>
                <li><a href="dashboard.html">Home</a></li>
                <li><a href="managesupply.html" class="active">Manage Supply</a></li>
                <li><a href="manageusers.html">Manage Users</a></li>
                <li><a href="reports.html">Reports</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </aside>
        <main class="main-content">
            <h1>Manage Supply</h1>
            
            <!-- Add Supply Section -->
            <section class="add-supply">
                <h2>Add New Supply</h2>
                <form action="add_supply.php" method="post">
                    <label for="supplyName">Supply Name:</label>
                    <input type="text" id="supplyName" name="supplyName" required>
                    
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" required>
                    
                    <label for="supplier">Supplier:</label>
                    <input type="text" id="supplier" name="supplier" required>
                    
                    <button type="submit">Add Supply</button>
                </form>
            </section>
            
            <!-- View Supplies Section -->
            <section class="view-supplies">
                <h2>Existing Supplies</h2>
                <table>
                    <thead>
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