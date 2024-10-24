<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="editproduct.css">
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Edit Product</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-7">
                    <form id="editProductForm">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-th-large"></i>
                                </span>
                                <input type="text" class="form-control" name="product-title" value="Enter product name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="product-categorie" required>
                                        <option value="">Select category</option>
                                        <option value="1" selected>Phones</option>
                                        <option value="2">laptops</option>
                                        <option value="2">Cables</option>

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="product-photo">
                                        <option value="">No image</option>
                                        <option value="1">.....</option>
                                    </select>
                               </div>  
                            </div> 
                            <button type="submit" style="background-color: darkblue; color: white; margin-top: 10px;"class="btn btn-primary">Update Product</a>
                        </div> 
                    </form>      
                </div> 
            </div>  
        </div> 
    </div> 
</div>
</div>
</body>       