<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .rounded-button {
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

    </style>
</head>
<body>

<?php require 'sidebaradmin.php'; ?>
<div class="container-fluid">
    <div class="main-content"> 
        <section class="overview-section my-4">
            <h2>Overview</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h3>Total Businesses</h3>
                        <p>5</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h3>Total Products</h3>
                        <p>120</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3">
                        <h3>Monthly Sales</h3>
                        <p>$12,400</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="businesses-section my-4">
            <h2>Manage Businesses</h2>
            <table class="table table-bordered">
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
                        <td>
                            <button class="btn btn-primary rounded-button">Edit</button>
                            <button class="btn btn-danger rounded-button">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Business 2</td>
                        <td>Jane Smith</td>
                        <td>30 Items</td>
                        <td>$3,500</td>
                        <td>
                            <button class="btn btn-primary rounded-button">Edit</button>
                            <button class="btn btn-danger rounded-button">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="reports-section my-4">
            <h2>Sales Reports</h2>
            <div class="report-summary">
                <p>Generate detailed reports on sales trends, inventory status, and more.</p>
                <button class="btn btn-success rounded-button">Generate Report</button>
            </div>
        </section>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>