<?php
include "../DBConnection.php";
include "../productsClass.php";
// Include the Product class file

$message = ""; // Initialize the message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $userID = $_POST['userID'];

    // Insert product into database using the Product class
    $isInserted = Product::InsertProductInDB_Static($name, $price, $qty, $userID);
    if ($isInserted) {
        $message = "Product added successfully!";
    } else {
        $message = "Failed to add product. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
</head>
<body>
<?php require 'sidebarsupplier.php'; ?>
<style>
    
    .form-control {
        height: 50px; 
        font-size: 16px;}
     .input-group-text { 
        height: 50px;
        font-size: 16px;
     } 
     .btn { 
        width: 100%;
        height: 50px;
        font-size: 16px; 
    }
</style>

    <div class="main-content"> 
    <H2>Add Products</H2> 
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info" id="msg" style="<?php echo $message ? 'display:block;' : 'display:none;'; ?>">
                        <?php echo $message; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 mx-auto"> 
                    <div class="card">
                        <div class="card-header">
                            <strong>
                                <span class="glyphicon glyphicon-th"></span>
                                <span>Add New Product</span>
                            </strong>
                        </div>
                        <div class="card-body">
                            <form action="addproduct.php" method="POST" id="addProductForm" style="width: 100%; margin: auto;"> <!-- Set width to 80% -->
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="glyphicon glyphicon-th-large"></i></span>
                                        <input type="text" class="form-control" name="name" placeholder="Product Name" required>
                                    </div>
                                </div>
                                <div class="mb-3">
    <div class="row">
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="glyphicon glyphicon-shopping-cart"></i></span>
                <input type="number" class="form-control" name="qty" placeholder="Product Quantity" required min="1">
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group">
                <span class="input-group-text"><i class="glyphicon glyphicon-usd"></i></span>
                <input type="number" class="form-control" name="price" placeholder="Product Price" required min="0">
                <span class="input-group-text">.00</span>
            </div>
        </div>
    </div>
</div>


                                <input type="hidden" name="userID" value="<?php echo $_SESSION['id']; ?>"> 
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
        this.submit(); 
    });
});
</script>

</body>
</html>