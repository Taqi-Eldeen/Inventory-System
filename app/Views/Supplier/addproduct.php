<?php
require_once __DIR__ . "/../../Config/DBConnection.php";
require_once(dirname(__FILE__) . "/../../Controller/ProductController.php");



if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Assuming the session stores supplierid for logged-in suppliers
$supplierid = $_SESSION['supplierid'];  // Get the supplier ID from the session



// If the supplierid is not set in the session, handle it (you may want to redirect or show an error)
$productsController = new ProductsController();
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call insert without parameters, it will use $_POST data inside the method
    $isInserted = $productsController->insert($supplierid);

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
<?php include '../User/sidebar.php'; ?>

<div class="main-content">
    <h2>Add Products</h2>
    <div class="container">
        <h1>Add New Product</h1>

        <!-- Display success or error messages -->
        <?php if (!empty($message)): ?>
            <p class="alert alert-info"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Form for adding a new product -->
        <form action="addproduct.php" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Product Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" id="price" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">Quantity:</label>
                <input type="number" id="qty" name="qty" class="form-control" required>
            </div>
            <!-- No need to include supplierid field as it is fetched from session -->
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
