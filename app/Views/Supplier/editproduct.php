<?php

require_once(dirname(__FILE__) . "/../../Controller/ProductController.php");

    $supplierId = $_SESSION['supplierid'];




require_once(dirname(__FILE__) . "/../../Controller/ProductController.php");
$controller = new ProductsController();

// Handle form submissions
if (isset($_POST['update_product'])) {
    $controller->edit();
}

if (isset($_POST['delete_product'])) {
    $controller->delete($_POST['delete_id']);
}

// Fetch all products for the current supplier
$products = $controller->ProductsBySupplier($supplierId);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>

<?php require 'sidebarsupplier.php'; ?>

<div class="main-content">
    <h2>Manage Products</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                    <td><?php echo htmlspecialchars($product['qty']); ?></td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editModal"
                            data-id="<?php echo $product['id']; ?>"
                            data-name="<?php echo htmlspecialchars($product['name']); ?>"
                            data-price="<?php echo htmlspecialchars($product['price']); ?>"
                            data-qty="<?php echo htmlspecialchars($product['qty']); ?>">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Edit Product -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="product_id" name="id">
                    <input type="hidden" name="supplierid" value="<?php echo  $supplierId; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" id="qty" name="qty" required>
                    </div>
                    <button type="submit" name="update_product" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
    // Populate the edit modal with the selected product's data
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var productID = button.data('id');
        var name = button.data('name');
        var price = button.data('price');
        var qty = button.data('qty');

        var modal = $(this);
        modal.find('#product_id').val(productID);
        modal.find('#name').val(name);
        modal.find('#price').val(price);
        modal.find('#qty').val(qty);
    });
</script>

</body>
</html>
