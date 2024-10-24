<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="addproduct.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<?php require 'sidebar.php'; ?>
    <div class="main-content"> 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" id="msg" style="display:none;"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Add New Product</span>
                    </strong>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form id="addProductForm" class="clearfix">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="product-title" placeholder="Product Title" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select class="form-control" name="product-categorie" required>
                                            <option value="">Select Product Category</option>
                                            <option value="1">phones</option>
                                            <option value="2">laptops</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-control" name="product-photo">
                                            <option value="">Select Product Photo</option>
                                           
                                            <option value="1">Photo 1</option>
                                            <option value="2">Photo 2</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-shopping-cart"></i>
                                            </span>
                                            <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-usd"></i>
                                            </span>
                                            <input type="number" class="form-control" name="buying-price" placeholder="Buying Price" required>
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="glyphicon glyphicon-usd"></i>
                                            </span>
                                            <input type="number" class="form-control" name="saleing-price" placeholder="Selling Price" required>
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" style="background-color: darkblue; color: white;" class="btn">Add Product</button>

                        </form>
                    </div>
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
