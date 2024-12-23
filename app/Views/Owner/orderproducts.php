<?php
require_once(dirname(__FILE__) . "/../../Controller/orderController.php");
require_once(dirname(__FILE__) . "/../../Controller/userController.php");
$ordersController = new OrdersController();
$usersController = new UsersController();
$boid = isset($_SESSION['boid']) ? $_SESSION['boid'] : '';
$orders = $ordersController->getOrdersByBusinessOwner($boid);
$suppliers = $usersController->getSuppliersByBoid($boid);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierId = isset($_POST['supplierid']) ? $_POST['supplierid'] : '';
    $message = isset($_POST['mesg']) ? $_POST['mesg'] : '';
    if (!empty($supplierId) && !empty($message)) {
        if ($ordersController->insert($supplierId, $message)) {
            echo "<script>alert('Order has been sent to the supplier successfully!');</script>";
        } else {
            echo "<script>alert('Failed to send the order.');</script>";
        }
    } else {
        echo "<script>alert('Please select a supplier and provide an order request message.');</script>";
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
    <table id="ordersTable" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>To Supplier ID</th>
                <th>Order Request</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($orders)): ?>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($order['orderid']); ?></td>
                        <td><?php echo htmlspecialchars($order['supplierid']); ?></td>
                        <td><?php echo htmlspecialchars($order['mesg']); ?></td>
                        <td><?php echo htmlspecialchars($order['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No orders available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align:center;">
                    <button id="generateOrder" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateOrderModal">
                        Generate Order
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="generateOrderModal" tabindex="-1" aria-labelledby="generateOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateOrderModalLabel">Generate Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" class="mb-4">
                    <input type="hidden" id="boid" name="boid" value="<?php echo htmlspecialchars($boid); ?>" required>

                    <div class="mb-3">
                        <label for="supplierid" class="form-label">Supplier</label>
                        <select id="supplierid" name="supplierid" class="form-control" required>
                            <option value="">Select Supplier</option>
                            <?php if (!empty($suppliers)): ?>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?php echo htmlspecialchars($supplier['id']); ?>">
                                        <?php echo htmlspecialchars($supplier['username']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No suppliers available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="mesg" class="form-label">Order Request</label>
                        <textarea id="mesg" name="mesg" class="form-control" rows="3" required></textarea>
                    </div>
                    <input type="hidden" name="status" value="Pending">

                    <button type="submit" class="btn btn-success">Submit Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

<script>
$(document).ready(function() {
    $('#ordersTable').DataTable();
});
</script>

</body>
</html>
