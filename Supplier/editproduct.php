<?php
session_start(); 

include "../DBConnection.php"; 
include "../productsClass.php";


if (!isset($_SESSION['id'])) {
    die("Session is not set. Please log in."); 
}

$currentSupplierID = $_SESSION['id']; 
$supplierProducts = Product::SelectProductsBySupplier($currentSupplierID); 



if (isset($_POST['delete_id'])) {
    $productID = intval($_POST['delete_id']);
    $product = new Product($productID); 

    if (Product::deleteProduct($product)) {
        echo "<script>alert('Product deleted successfully.');</script>";
        header("Location: editproduct.php");
        exit();
    } else {
        echo "<script>alert('Error deleting product.');</script>";
    }
}


if (isset($_POST['update_product'])) {
    $productID = intval($_POST['product_id']);
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $qty = intval($_POST['qty']);

    $product = new Product($productID); 
    $product->name = $name; 
    $product->price = $price; 
    $product->qty = $qty; 
    $product->userID = $currentSupplierID; 
    if ($product->UpdateProductInDB()) { 
        echo "<script>alert('Product updated successfully.');</script>";
        header("Location: editproduct.php");
        exit();
    } else {
        echo "<script>alert('Error updating product.');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <!-- New Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    
    <!-- New DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">

    <style>
        button.edit-btn, button.delete-btn {
            background-color: #001F3F;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 15px;
            cursor: pointer;
            margin-right: 10px;
        }

        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>

<div class="main-content"> 
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>ID Owner Of Product</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($supplierProducts as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product->name); ?></td>
                    <td><?php echo htmlspecialchars($product->price); ?></td>
                    <td><?php echo htmlspecialchars($product->qty); ?></td>
                    <td><?php echo htmlspecialchars($product->userID); ?></td>
                    <td>
                        <button class="edit-btn" 
                                data-id="<?php echo $product->ID; ?>" 
                                data-name="<?php echo htmlspecialchars($product->name); ?>" 
                                data-price="<?php echo htmlspecialchars($product->price); ?>" 
                                data-qty="<?php echo htmlspecialchars($product->qty); ?>" 
                                data-toggle="modal" 
                                data-target="#editModal">Edit</button>
                        <form action="editproduct.php" method="POST" style="display:inline;">
                            <input type="hidden" name="delete_id" value="<?php echo $product->ID; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Edit Product Modal -->
<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Product</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editProductForm" method="POST" action="editproduct.php">
                    <input type="hidden" id="product_id" name="product_id" value="">
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" class="form-control" id="price" name="price" required min="1">
                    </div>
                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" id="qty" name="qty" required min="0">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="update_product" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable(); // Initialize DataTables

        // Handle edit button click
        $('.edit-btn').on('click', function() {
            const productID = $(this).data('id');
            const name = $(this).data('name');
            const price = $(this).data('price');
            const qty = $(this).data('qty');

            $('#product_id').val(productID);
            $('#name').val(name);
            $('#price').val(price);
            $('#qty').val(qty);

            // Show the modal
            $('#editModal').modal('show');
        });
    });
</script>
</body>
</html>
