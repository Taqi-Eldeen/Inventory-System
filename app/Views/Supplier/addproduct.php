<?php
// Include the necessary controller and model files
require_once __DIR__ . "/../../Config/DBConnection.php";
require_once(dirname(__FILE__) . "/../../Controller/ProductController.php");

// Create an instance of the ProductsController
$productsController = new ProductsController();

$message = ""; // Initialize the message variable

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the insert method from ProductsController
    $isInserted = $productsController->insert();

    // Display success or error messages based on the result
    if ($isInserted) {
        $message = "Product added successfully!";
    } else {
        $message = "Failed to add product. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../../public/css/addproduct.css">
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>

<div class="main-content"> 
    <h2>Add Products</h2>
    <div class="container">
        <h1>Add New Product</h1>

        <!-- Display success or error messages -->
        <?php if (!empty($message)): ?>
            <p class="alert alert-info"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- The form for adding a new product -->
        <form action="addproduct.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Product Price:</label>
                <input type="number" id="price" name="price" class="form-control" min="0" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">Product Quantity:</label>
                <input type="number" id="qty" name="qty" class="form-control" min="1" required>
            </div>
            <input type="hidden" name="supplierid" value="<?php echo $_SESSION['id']; ?>">
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>
</body>
</html>
