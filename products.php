<?php

include "DBConnection.php"; 
include "productsClass.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products DataTable</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="products.css">
</head>
<body>
<?php require 'sidebar.php'; ?>
<div class="main-content"> 
<H2>Stock</H2>

    <table id="productsTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $products = Product::SelectAllProductsInDB(); 

            foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product->ID); ?></td>
                    <td><?php echo htmlspecialchars($product->name); ?></td>
                    <td><?php echo htmlspecialchars($product->price); ?></td>
                    <td><?php echo htmlspecialchars($product->qty); ?></td>
                    <td><?php echo htmlspecialchars($product->userID); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:right;"><strong>Total Products:</strong></td>
                <td><?php echo count($products); ?></td> 
            </tr>
        </tfoot>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
$(document).ready(function() {
    $('#productsTable').DataTable();
});
</script>
</body>
</html>
