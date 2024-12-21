<?php
require_once(dirname(__FILE__) . "/../../Controller/inventoryController.php");

// Create an instance of the InventoryController
$inventoryController = new InventoryController();

$message = ""; // Initialize the message variable
$inventoryData = null; // Initialize the inventory data variable

// Automatically fetch inventory for the business owner when the page loads
$businessOwnerId = $_SESSION['boid'];
$inventoryData = $inventoryController->getOrCreateInventory($businessOwnerId);

// Handle product removal
if (isset($_POST['remove_product'])) {
    $productId = $_POST['product_id'];

    // Call the removeProduct method from the InventoryController
    $response = $inventoryController->removeProduct($productId);
    $responseData = json_decode($response, true);

    if ($responseData['success']) {
        $message = $responseData['message'];
        // Refresh inventory data after product removal
        $inventoryData = $inventoryController->getOrCreateInventory($businessOwnerId);
    } else {
        $message = $responseData['message'];
    }
}

// Display success or error messages based on the result
if ($inventoryData && isset($inventoryData['invid'])) {
    $message = "Inventory loaded successfully! Inventory ID: " . $inventoryData['invid'];
} else {
    $message = "Failed to load inventory. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Owner Inventory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../../public/css/manageinventory.css">

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this product?");
        }
    </script>
</head>
<body>
    <?php include '../User/sidebar.php'; ?>

    <div class="main-content">
    <div class="container mt-4">
        <h2 class="mb-4 text-start">Business Owner Inventory</h2>

        <!-- Display success or error messages -->
        <p class="alert alert-info"><?php echo $message; ?></p>

        <!-- Inventory Table -->
        <div class="table-responsive">
            <table id="inventoryTable" class="table table-bordered table-striped">
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
    </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
