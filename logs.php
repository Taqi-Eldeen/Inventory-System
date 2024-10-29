<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="logs.css">
</head>
<body>
<?php require 'sidebar.php'; ?>
<div class="main-content"> 
<H2>Logs</H2>
<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sender Name</th>  <!-- Added Sender Name Column -->
            <th>Start Date</th>
            <th>End Date</th>
            <th>Product ID</th>
            <th>Message</th>
            <th>User ID</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>John Doe</td>  <!-- Sender Name -->
            <td>2024-10-01</td>
            <td>2024-10-10</td>
            <td>61</td>
            <td>Product launch scheduled.</td>
            <td>101</td>
            <td>Active</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Jane Smith</td>  <!-- Sender Name -->
            <td>2024-10-05</td>
            <td>2024-10-15</td>
            <td>62</td>
            <td>Update on product specifications.</td>
            <td>102</td>
            <td>Completed</td>
        </tr>
        <!-- Add more rows as needed -->
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align:right;"><strong>Total Records:</strong></td>
            <td>2</td> <!-- Adjust this value based on your data -->
        </tr>
        <tr>
            <td colspan="8" style="text-align:center;">* All dates are in YYYY-MM-DD format.</td>
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
    $('#example').DataTable();
});
</script>
</body>
</html>
