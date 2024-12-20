<?php
include_once 'sidebarowner.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Business Owner Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
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
    </body>
    <script>
        const ctx = document.getElementById('sales-chart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
            label: 'Sales',
            data: [1000, 2000, 5, 1300, 1400],
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

const ctx2 = document.getElementById('stock-chart').getContext('2d');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
        datasets: [{
            label: 'Stock Levels',
            data: [500, 400, 300, 200, 100],
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
const ctx3 = document.getElementById('pie-chart').getContext('2d');
new Chart(ctx3, {
    type: 'pie', 
    data: {
        labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
        datasets: [{
            label: 'Stock Levels',
            data: [500, 400, 300, 200, 100],
            backgroundColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ': ' + tooltipItem.raw;
                    }
                }
            }
        }
    }
});
    </script>
</html>
