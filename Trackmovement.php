<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Stock Movements</title>
    <link rel="stylesheet" href="trackmovement.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>
    <div class="main-content"> 
        <div class="container">
            <h2 class="mt-4">Stock Movements</h2>
            <form id="stockMovementForm" class="mb-4">
                <div class="mb-3">
                    <label for="product-name" class="form-label">Product Name:</label>
                    <input type="text" class="form-control" id="product-name" required>
                </div>
                <div class="mb-3">
                    <label for="movement-type" class="form-label">Movement Type:</label>
                    <select class="form-select" id="movement-type" required>
                        <option value="restock">Restock</option>
                        <option value="sale">Sale</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity:</label>
                    <input type="number" class="form-control" id="quantity" required>
                </div>
                <button type="submit" class="btn btn-primary">Record Movement</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product Name</th>
                        <th>Movement Type</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody id="movement-log">
                    <!-- Movement logs will be appended here -->
                </tbody>
            </table>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $('#stockMovementForm').on('submit', function(event) {
            event.preventDefault();
            // Add your form submission logic here (e.g., AJAX request)
            // Example of adding data to the table
            const productName = $('#product-name').val();
            const movementType = $('#movement-type').val();
            const quantity = $('#quantity').val();
            const date = new Date().toLocaleString();

            $('#movement-log').append(`
                <tr>
                    <td>${date}</td>
                    <td>${productName}</td>
                    <td>${movementType}</td>
                    <td>${quantity}</td>
                </tr>
            `);

            // Clear the form fields
            $('#stockMovementForm')[0].reset();
        });
    });
</script>

</body>
</html>