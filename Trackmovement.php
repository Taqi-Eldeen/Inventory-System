<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Stock Movements</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .table {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<?php require 'sidebar.php'; ?>
    <div class="main-content"> 
<div class="container">
    <h2>Stock Movements</h2>
    <form id="stockMovementForm">
        <div class="form-group">
            <label for="product-name">Product Name:</label>
            <input type="text" class="form-control" id="product-name" required>
        </div>
        <div class="form-group">
            <label for="movement-type">Movement Type:</label>
            <select class="form-control" id="movement-type" required>
                <option value="restock">Restock</option>
                <option value="sale">Sale</option>
            </select>
        </div>
        <div class="form-group">
            <label for="quantity">Quantity:</label>
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
            <!-- Stock movements will be logged here -->
        </tbody>
    </table>
</div>
    </div>

</body>
</html>
