<?php
require_once(dirname(__FILE__) . '/../model/report.php');
require_once(dirname(__FILE__) . '/../Controller/Controller.php');

class ReportsController extends Controller {
    private $reportsModel;

    public function __construct() {
        $this->reportsModel = new Reports();
        parent::__construct($this->reportsModel);
    }

    
    public function insert() {
        
        $empid = $_POST['empid'];
        $mesg = $_POST['mesg'];

        if (!empty($empid) && !empty($mesg)) {
            return $this->reportsModel->insertReport($empid, $mesg);
        } else {
            echo "Employee ID and message are required to submit a report.";
            return false;
        }
    }

    
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

    
    public function delete($repid) {
        if (!empty($repid)) {
            return $this->reportsModel->deleteReport($repid);
            header("Location: reportOwner.php"); 
            
        } else {
            echo "Report ID is required to delete a report.";
            return false;
        }
    }

    
    public function getReports() {
        return $this->reportsModel->getReports();
    }

    
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

    
    public function getReportsByEmployee($empid) {
        return $this->reportsModel->getReportsByEmployee($empid);
    }

    
    public function getReportsByBusinessOwner($boid) {
        return $this->reportsModel->getReportsByBusinessOwner($boid);
    }
    
}
?>
