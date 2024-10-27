<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="addproduct.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>
    <div class="main-content"> 
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" id="msg" style="display:none;"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <span class="glyphicon glyphicon-th"></span>
                                <span>Add New Product</span>
                            </strong>
                        </div>
                        <div class="card-body">
                            <form id="addProductForm" class="clearfix">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="glyphicon glyphicon-th-large"></i>
                                        </span>
                                        <input type="text" class="form-control" name="product-title" placeholder="Product Title" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-select" name="product-categorie" required>
                                                <option value="">Select Product Category</option>
                                                <option value="1">Phones</option>
                                                <option value="2">Laptops</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select" name="product-photo">
                                                <option value="">Select Product Photo</option>
                                                <option value="1">Photo 1</option>
                                                <option value="2">Photo 2</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                                </span>
                                                <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="glyphicon glyphicon-usd"></i>
                                                </span>
                                                <input type="number" class="form-control" name="buying-price" placeholder="Buying Price" required>
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="glyphicon glyphicon-usd"></i>
                                                </span>
                                                <input type="number" class="form-control" name="selling-price" placeholder="Selling Price" required>
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary" style="background-color: darkblue; color: white;">Add Product</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function() {
        $('#addProductForm').on('submit', function(event) {
            event.preventDefault();
            // Add your form submission logic here (e.g., AJAX request)
            $('#msg').text('Product added successfully!').addClass('alert-success').show();
        });
    });
</script>

</body>
</html>