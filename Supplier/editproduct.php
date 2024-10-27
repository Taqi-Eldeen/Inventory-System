<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="editproduct.css">
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
                <div class="card">
                    <div class="card-header">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span>
                            <span>Edit Product</span>
                        </strong>
                    </div>
                    <div class="card-body">
                        <div class="col-md-7">
                            <form id="editProductForm">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="glyphicon glyphicon-th-large"></i>
                                        </span>
                                        <input type="text" class="form-control" name="product-title" value="Enter product name" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-select" name="product-categorie" required>
                                                <option value="">Select category</option>
                                                <option value="1" selected>Phones</option>
                                                <option value="2">Laptops</option>
                                                <option value="3">Cables</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-select" name="product-photo">
                                                <option value="">No image</option>
                                                <option value="1">.....</option>
                                            </select>
                                        </div>  
                                    </div> 
                                    <button type="submit" class="btn btn-primary mt-3" style="background-color: darkblue;">Update Product</button>
                                </div> 
                            </form>      
                        </div> 
                    </div>  
                </div> 
            </div> 
        </div>
    </div>
</body>
</html>