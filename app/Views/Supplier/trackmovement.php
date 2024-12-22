<?php
require_once(dirname(__FILE__) . "/../../Controller/orderController.php");

$ordersController = new OrdersController();

// Check if the user is a supplier and get their ID
$supplierId = isset($_SESSION['supplierid']) ? $_SESSION['supplierid'] : '';

// Fetch orders for the supplier
$orders = [];
if (!empty($supplierId)) {
    $orders = $ordersController->getOrdersBySupplier($supplierId);  // Assuming a method like this exists
}

// Handle order acceptance (change status to 'Completed')
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accept'])) {
    $orderId = $_POST['orderid'];
    if ($ordersController->updateOrderStatus($orderId, 'Completed')) {
        echo "<script>alert('Order status updated to Completed.');</script>";
    } else {
        echo "<script>alert('Failed to update order status.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="logs.css">
</head>
<body>

<?php include '../User/sidebar.php'; ?>
<div class="main-content">
    <h2>Your Orders</h2>

    <!-- Orders Table -->
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Business Owner ID</th>
                <th>Order Request</th>
                <th>Status</th>
                <th>Actions</th>  <!-- New column for action buttons -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['orderid']); ?></td>
                        <td><?php echo htmlspecialchars($order['boid']); ?></td>
                        <td><?php echo htmlspecialchars($order['mesg']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                        <td>
                            <?php if ($order['status'] !== 'Completed'): ?>  <!-- Only show button if status is not completed -->
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="orderid" value="<?php echo htmlspecialchars($order['orderid']); ?>">
                                    <button type="submit" name="accept" class="btn btn-success">
                                        Accept
                                    </button>
                                </form>
                            <?php else: ?>
                                <span class="text-success">Completed</span>  <!-- Show status text if completed -->
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No orders available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
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
