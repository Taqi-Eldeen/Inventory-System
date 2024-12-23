<?php
require_once(dirname(__FILE__) . "/../../Controller/reportController.php");

$reportsController = new ReportsController();
$businessOwnerId = isset($_SESSION['boid']) ? $_SESSION['boid'] : '';
$reports = [];
if (!empty($businessOwnerId)) {
    $reports = $reportsController->getReportsByBusinessOwner($businessOwnerId);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $repid = $_POST['repid'];
    $reportsController->delete($repid);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Table</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="logs.css">
</head>
<body>

<?php include '../User/sidebar.php'; ?>
<div class="main-content">
    <h2>All Employee Reports</h2>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Employee ID</th>
                <th>Message</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['repid']); ?></td>
                        <td><?php echo htmlspecialchars($report['empid']); ?></td>
                        <td><?php echo htmlspecialchars($report['mesg']); ?></td>
                        <td>
                            <form method="POST" action="" style="display:inline;">
                                <input type="hidden" name="repid" value="<?php echo htmlspecialchars($report['repid']); ?>">
                                <button type="submit" name="delete" class="btn btn-danger">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No reports available.</td>
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
