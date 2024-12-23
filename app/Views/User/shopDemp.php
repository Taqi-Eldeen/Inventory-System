<?php
require_once(dirname(__FILE__) . "/../../Controller/reportController.php");

$reportsController = new ReportsController();
$empid = isset($_SESSION['empid']) ? $_SESSION['empid'] : '';
$reports = [];
if (!empty($empid)) {
    $reports = $reportsController->getReportsByEmployee($empid);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reportsController->insert();
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
    <h2>Your Reports</h2>
    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>Report ID</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reports)): ?>
                <?php foreach ($reports as $report): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($report['repid']); ?></td>
                        <td><?php echo htmlspecialchars($report['mesg']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">No reports available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button id="generateReport" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateModal">
                        Generate Report
                    </button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="modal fade" id="generateModal" tabindex="-1" aria-labelledby="generateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="generateModalLabel">Generate Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="" class="mb-4">
                    <div class="mb-3">
                        <label for="empid" class="form-label">Employee ID</label>
                        <input type="text" id="empid" name="empid" class="form-control" value="<?php echo htmlspecialchars($empid); ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="mesg" class="form-label">Message</label>
                        <textarea id="mesg" name="mesg" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Report</button>
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
    $('#example').DataTable();
});
</script>

</body>
</html>
