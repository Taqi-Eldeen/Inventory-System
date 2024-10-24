<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <link rel="stylesheet" href="products.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>
    <div class="main-content"> 
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info" id="msg" style="display:none;"></div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <div class="pull-right">
                        <a href="addproduct.html" style="background-color: darkblue; color: white; margin-top: 10px;"class="btn btn-primary">Add New</a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Photo</th>
                                <th>Product Title</th>
                                <th class="text-center" style="width: 10%;">Categories</th>
                                <th class="text-center" style="width: 10%;">In-Stock</th>
                                <th class="text-center" style="width: 10%;">Buying Price</th>
                                <th class="text-center" style="width: 10%;">Selling Price</th>
                                <th class="text-center" id='productform' style="width: 10%;">Product Added</th>
                                <th class="text-center" style="width: 10%;">Supplier</th>
                                <th class="text-center" style="width: 100px;">Actions</th>
                            </tr>
                        </thead>
                    <tbody>
                            <tr>
                                <td class="text-center">1</td>
                                <td>////</td>
                                <td>iphone 16</td>
                                <td>Phones</td>
                                <td>47</td>
                                <td>65,000 EGP</td>
                                <td>80,000 EGP</td>
                                <td>10 October, 2023, 7:45:33 AM</td>
                                <td> smart koshk usa </td>
                                <td>  <a href="delete_product.php?id=1" class="btn btn-primary" style="padding: 2px 5px; font-size: 12px;" title="Delete" data-toggle="tooltip">
                                <i class="fa-solid fa-trash"></i>
                                                      </a> </td>
                           </tr>  
                           <tr>
                                <td class="text-center">2</td>
                                <td>////</td>
                                <td>Macbook</td>
                                <td>laptops</td>
                                <td>24</td>
                                <td>90,000 EGP</td>
                                <td>120,000 EGP</td>
                                <td>17 October, 2024, 9:57:22 AM</td>
                                <td> alarm store uae </td>
                                <td>  <a href="delete_product.php?id=1" class="btn btn-primary" style="padding: 2px 5px; font-size: 12px;" title="Delete" data-toggle="tooltip">
                                <i class="fa-solid fa-trash"></i>
                                   </a> </td>
                        </tr> 
                   </tbody> 
                </div>      
            </div>        
        </div>           
    </div> 
</div>  
</div>  

                   
               
                                
      
