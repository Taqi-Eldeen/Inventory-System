<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="editproduct.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.min.js"></script>
</head>
<body>
    <?php require 'sidebar.php'; ?>

    <div class="main-content"> 
        <table id="supplierTable" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Tiger Nixon</td>
                    <td><button class="btn btn-primary">Connect with this supplier</button></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Garrett Winters</td>
                    <td><button class="btn btn-primary">Connect with this supplier</button></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Ashton Cox</td>
                    <td><button class="btn btn-primary">Connect with this supplier</button></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Cedric Kelly</td>
                    <td><button class="btn btn-primary">Connect with this supplier</button></td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>Airi Satou</td>
                    <td><button class="btn btn-primary">Connect with this supplier</button></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>Supplier ID</th>
                    <th>Supplier Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#supplierTable').DataTable();
        });
    </script>

</body>
</html>
