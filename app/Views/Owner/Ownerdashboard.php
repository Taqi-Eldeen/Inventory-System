<?php
include_once 'sidebarowner.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Owner Dashboard</title>
    <link rel="stylesheet" href="businessownerdashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <link rel="stylesheet" href="../../../public/css/supplierdashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="main-content">
        <h2>Dashboard</h2>

        <ul class="box-info">
            <li>
                <i class="fa-solid fa-user"></i>
                <span class="text">
                    <h3>2450</h3>
                    <p>Users</p>
                </span>
            </li>
            <li>
                <i class="fa-solid fa-truck-fast"></i>
                <span class="text">
                    <h3>3</h3>
                    <p>Suppliers</p>
                </span>
            </li>
            <li>
                <i class="fa-solid fa-briefcase"></i>
                <span class="text">
                    <h3>150</h3>
                    <p>Businesses</p>
                </span>
            </li>
            <li>
                <i class="fa-solid fa-chart-line"></i>
                <span class="text">
                    <h3>$75,000</h3>
                    <p>Revenue</p>
                </span>
            </li>
            <li>
                <i class="fa-solid fa-people-carry"></i>
                <span class="text">
                    <h3>300</h3>
                    <p>Employees</p>
                </span>
            </li>
        </ul>

        <div class="charts">
            <canvas id="salesChart"></canvas>
            <canvas id="employeeChart"></canvas>
        </div>
    </div>

    <script>
        const ctxSales = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctxSales, {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Sales',
                    data: [5000, 7000, 8000, 6000, 9000, 7500],
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        const ctxEmployee = document.getElementById('employeeChart').getContext('2d');
        const employeeChart = new Chart(ctxEmployee, {
            type: 'line',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                datasets: [{
                    label: 'Employees',
                    data: [50, 60, 70, 65, 80, 75],
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    fill: false,
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>