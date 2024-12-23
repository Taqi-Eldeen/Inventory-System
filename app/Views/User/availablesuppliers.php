<?php
require_once(dirname(__FILE__) . "/../../Controller/inventoryController.php");
$inventoryController = new InventoryController();

$empid = $_SESSION['empid'];
$inventoryData = $inventoryController->getInventoryForEmployee($empid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../User/sidebar.php'; ?>

<div class="main-content container mt-4">
    <h2>Employee Inventory</h2>
    <?php if (!$inventoryData): ?>
        <p>No products found for this employee's inventory.</p>
    <?php else: ?>
        <table id="inventoryTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Supplier User ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($inventoryData as $product) {
                    echo "<tr>
                            <td>{$product['product_id']}</td>
                            <td>{$product['product_name']}</td>
                            <td>{$product['price']}</td>
                            <td>{$product['qty']}</td>
                            <td>{$product['supplier_name']}</td>
                        </tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-center">* Products displayed for this employee's inventory.</td>
                </tr>
            </tfoot>
        </table>
    <?php endif; ?>
</div>

</body>
</html>
