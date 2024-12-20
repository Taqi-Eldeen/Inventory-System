<?php
require_once(dirname(__FILE__) . "/../../Controller/inventoryController.php");

// Create an instance of the InventoryController
$inventoryController = new InventoryController();

$message = ""; // Initialize the message variable
$inventoryData = null; // Initialize the inventory data variable

// Handle form submission for creating inventory
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get business owner ID from session
    $businessOwnerId = $_SESSION['boid'];
    
    // Call the getOrCreateInventory method from InventoryController
    $inventoryData = $inventoryController->getOrCreateInventory($businessOwnerId);

    // Display success or error messages based on the result
    if ($inventoryData && isset($inventoryData['invid'])) {
        $message = "Inventory created successfully! Inventory ID: " . $inventoryData['invid'];
    } else {
        $message = "Failed to create inventory. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require 'sidebarowner.php'; ?>

<div class="main-content">
    <h2>Business Owner Inventory</h2>

    <!-- Display success or error messages -->
    <p><?php echo $message; ?></p>

    <form action="manageinventory.php" method="POST">
        <button type="submit" class="btn btn-primary">Create Inventory</button>
    </form>

    <!-- Inventory Table -->
    <table id="inventoryTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Supplier Name</th>
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
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No products found for this inventory.</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align:center;">* Inventory details fetched for the business owner.</td>
            </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
