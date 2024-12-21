<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 20px;
            transition: transform 0.3s ease;
            margin-bottom: 5px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .rounded-button {
            border-radius: 50px;
            transition: background-color 0.3s ease;
        }

        .rounded-button:hover {
            background-color: #0056b3;
        }

        .main-content {
            padding: 30px;
        }

        .overview-section {
            margin-bottom: 40px;
        }

        .businesses-section {
            margin-bottom: 40px;
        }

        .reports-section {
            margin-bottom: 40px;
        }

        .business-card {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        .text-center {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<?php include '../User/sidebar.php'; ?>
<div>
    <div class="main-content"> 
        <section class="overview-section">
            <h2>Overview</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-center p-3 rounded shadow animate__animated animate__fadeIn">
                        <i class="fa-solid fa-building fa-3x"></i>
                        <h3>Total Businesses</h3>
                        <p>5</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3 rounded shadow animate__animated animate__fadeIn">
                        <i class="fa-solid fa-box fa-3x"></i>
                        <h3>Total Products</h3>
                        <p>120</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center p-3 rounded shadow animate__animated animate__fadeIn">
                        <i class="fa-solid fa-dollar-sign fa-3x"></i>
                        <h3>Monthly Sales</h3>
                        <p>$12,400</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="businesses-section">
            <h2>Manage Businesses</h2>
            <div class="row">
                <div class="col-md-4 business-card">
                    <div class="card p-3 rounded shadow">
                        <h5>Business 1</h5>
                        <p>Owner: John Doe</p>
                        <p>Stock Level: 45 Items</p>
                        <p>Sales: $5,000</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary rounded-button">Edit</button>
                            <button class="btn btn-danger rounded-button">Delete</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 business-card">
                    <div class="card p-3 rounded shadow">
                        <h5>Business 2</h5>
                        <p>Owner: Jane Smith</p>
                        <p>Stock Level: 30 Items</p>
                        <p>Sales: $3,500</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary rounded-button">Edit</button>
                            <button class="btn btn-danger rounded-button">Delete</button>
                        </div>
                    </div>
                </div>
                <!-- Add more business cards as needed -->
            </div>
        </section>

        <section class="reports-section">
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