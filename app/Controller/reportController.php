<?php
require_once(dirname(__FILE__) . '/../model/report.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class ReportsController extends Controller {
    private $reportsModel;

    public function __construct() {
        $this->reportsModel = new Reports();
        parent::__construct($this->reportsModel);
    }

    // Insert a new report
    public function insert() {
        // Access $_POST directly within the method
        $empid = $_POST['empid'];
        $mesg = $_POST['mesg'];

        if (!empty($empid) && !empty($mesg)) {
            return $this->reportsModel->insertReport($empid, $mesg);
        } else {
            echo "Employee ID and message are required to submit a report.";
            return false;
        }
    }

    // Edit an existing report
    public function edit() {
        $repid = $_REQUEST['repid'];
        $empid = $_REQUEST['empid'];
        $mesg = $_REQUEST['mesg'];

        if (!empty($repid) && !empty($empid) && !empty($mesg)) {
            return $this->reportsModel->updateReport($repid, $empid, $mesg);
        } else {
            echo "Report ID, Employee ID, and message are required to edit a report.";
            return false;
        }
    }

    // Delete a report
    public function delete($repid) {
        if (!empty($repid)) {
            return $this->reportsModel->deleteReport($repid);
            header("Location: reportOwner.php"); // Redirect back to the reports page after deletion
            
        } else {
            echo "Report ID is required to delete a report.";
            return false;
        }
    }

    // Get all reports
    public function getReports() {
        return $this->reportsModel->getReports();
    }

    // Get report details by ID
    public function getReportByID($repid) {
        $reports = $this->reportsModel->getReports();
        foreach ($reports as $report) {
            if ($report['repid'] == $repid) {
                return $report;
            }
        }
        echo "Report with ID $repid not found.";
        return null;
    }

    // Fetch reports by employee ID
    public function getReportsByEmployee($empid) {
        return $this->reportsModel->getReportsByEmployee($empid);
    }

    // Fetch reports of all employees for the business owner
    public function getReportsByBusinessOwner($boid) {
        return $this->reportsModel->getReportsByBusinessOwner($boid);
    }
    // Other controller methods can go here
}
?>
