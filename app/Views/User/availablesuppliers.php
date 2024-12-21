<?php
require_once(dirname(__FILE__) . "/../../Controller/inventoryController.php");

// Create an instance of the InventoryController
$inventoryController = new InventoryController();

$empid = $_SESSION['empid'];
$inventoryController->getInventoryForEmployee($empid);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Add JavaScript for confirmation dialog -->
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
</head>
<body>
<?php include '../User/sidebar.php'; ?>

<div class="main-content container mt-4">
    <h2>Business Owner Inventory</h2>

    <!-- Display success or error messages -->


    <!-- Inventory Table -->
    <table id="inventoryTable" class="table table-striped">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Supplier User ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (isset($inventoryData['products']) && !empty($inventoryData['products'])) {
            foreach ($inventoryData['products'] as $product) {
                echo "<tr>
                        <td>{$product['product_id']}</td>
                        <td>{$product['product_name']}</td>
                        <td>{$product['price']}</td>
                        <td>{$product['qty']}</td>
                        <td>{$product['supplier_name']}</td>
                        <td>
                            <form action='manageinventory.php' method='POST' style='display:inline;' onsubmit='return confirmDelete();'>
                                <input type='hidden' name='product_id' value='{$product['product_id']}'>
                                <button type='submit' name='remove_product' class='btn btn-danger btn-sm'>Remove</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No products found for this inventory.</td></tr>";
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="6" class="text-center">* Inventory details fetched for the business owner.</td>
            </tr>
        </tfoot>
    </table>
</div>

</body>
</html>