<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>


    <?php require 'sidebar.php'; ?>
    <div class="main-content"> 
        <section class="overview-section">
            <h2>Overview</h2>
            <div class="card-container">
                <div class="card">
                    <h3>Total Businesses</h3>
                    <p>5</p>
                </div>
                <div class="card">
                    <h3>Total Products</h3>
                    <p>120</p>
                </div>
                <div class="card">
                    <h3>Monthly Sales</h3>
                    <p>$12,400</p>
                </div>
            </div>
        </section>

        <section class="businesses-section">
            <h2>Manage Businesses</h2>
            <table>
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Owner</th>
                        <th>Stock Level</th>
                        <th>Sales</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Business 1</td>
                        <td>John Doe</td>
                        <td>45 Items</td>
                        <td>$5,000</td>
                        <td><button>Edit</button> <button>Delete</button></td>
                    </tr>
                    <tr>
                        <td>Business 2</td>
                        <td>Jane Smith</td>
                        <td>30 Items</td>
                        <td>$3,500</td>
                        <td><button>Edit</button> <button>Delete</button></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="reports-section">
            <h2>Sales Reports</h2>
            <div class="report-summary">
                <p>Generate detailed reports on sales trends, inventory status, and more.</p>
                <button>Generate Report</button>
            </div>
        </section>
    </div>
</div>
</body>
</html>
