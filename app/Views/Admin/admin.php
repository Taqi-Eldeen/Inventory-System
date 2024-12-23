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
if (!is_array($products))
    $products = [];
$productsSlices = array_slice($products, 0, 4);
?>
<html>
    <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css">
    <link rel="stylesheet" href="../../../public/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body>
        <div class="main-content">

        <div class="container-xs">
            <div class="row">
                <div class="col-md-6">
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
                <div class="col-sm-6 ">
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
                            <?php foreach($productsSlices as $product) : ?>
                                <tr>
                                <th scope="row"><?php echo $product->getID() ?> </th>
                                <td><?php echo $product->getName() ?> </td>
                                <td>$<?php echo $product->getPrice() ?> </td>
                                <td><?php echo $product->getQty() ?> </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row my-4">
                <div class="col">
                    <div class="card p-4">
                        <h3 class="card-title">Product Quantity Distribution</h3>
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </body>
    <script>
        <?php
            $productNames = [];
            $productQty = [];
            foreach($products as $product)
            {
                array_push($productNames, $product->getName());
                array_push($productQty, $product->getQty());
            }
            $js_array = json_encode($productNames);
            echo "var productNames = ". $js_array . ";\n";
            $js_array = json_encode($productQty);
            echo "var productQty = ". $js_array . ";\n";
        ?>
        var ctx = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Quantity',
                    data: productQty,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
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
    </script>
</html>
