<?php
require_once(dirname(__FILE__) . "/../../Controller/UserController.php");
require_once(dirname(__FILE__) . "/../../Controller/ProductController.php");
require_once(dirname(__FILE__) . "/../User/sidebar.php");

$userController = new UsersController();

$boid = $_SESSION['boid'];
$employees = $userController->getEmployeeByBOid($boid);
$employee_count = count($employees);

$suppliers = $userController->getSuppliersByBOid($boid);
$supplier_count = count($suppliers);

$productController = new ProductsController();
$products = $productController->ProductsByBusinessOwner($boid);
$products = array_slice($products, 0, 4);
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
        <div class="container-xs">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Supplier</h5>
                            <p class="card-text">
                                <i class="fa-solid fa-truck-fast"></i>
                                <?php echo $supplier_count ?> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Employees</h5>
                            <p class="card-text">
                                <i class="fa-solid fa-people-carry"></i>
                                <?php echo $employee_count ?> 
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 ">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Employees</h5>
                            <p class="card-text">
                                <i class="fa-solid fa-people-carry"></i>
                                <?php echo $employee_count ?> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col">
                    <div class="card p-4">
                        <h3 class="card-title">Recent Added Products</h3>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">ID </th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($products as $product) : ?>
                                <thead>
                                    <tr>
                                    <th scope="row"><?php echo $product->getID() ?> </th>
                                    <td><?php echo $product->getName() ?> </th>
                                    <td>$<?php echo $product->getPrice() ?> </th>
                                    <td><?php echo $product->getQty() ?> </th>
                                    </tr>
                                </thead>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
            </div>
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
