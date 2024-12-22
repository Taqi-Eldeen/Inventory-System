<?php
require_once(dirname(__FILE__) . '/../model/Model.php');

class Reports extends Model {
    private $reports;

    function __construct() {
        $this->reports = [];
        $this->db = $this->connect(); // Initialize the database connection
        $this->fillArray();
    }

    // Populate the reports array
    function fillArray() {
        $this->reports = [];
        $result = $this->readReports();

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $report = [
                    "repid" => $row["repid"],
                    "empid" => $row["empid"],
                    "mesg"  => $row["mesg"]
                ];
                array_push($this->reports, $report);
            }
        }
    }

    // Return the reports array
    function getReports() {
        return $this->reports;
    }

    // Fetch all reports from the database
    function readReports() {
        $sql = "SELECT * FROM report";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Insert a new report
    function insertReport($empid, $mesg) {
        $insertReportSql = "INSERT INTO report (empid, mesg) VALUES (?, ?)";
        $stmt = $this->db->prepare($insertReportSql);
        $stmt->bind_param("is", $empid, $mesg);
    
        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the reports array
            return true;
        } else {
            echo "ERROR: Could not insert report. " . $this->db->error;
            return false;
        }
    }

    // Delete a report by ID
    function deleteReport($repid) {
        $sql = "DELETE FROM report WHERE repid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $repid);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the reports array
            return true;
        } else {
            echo "ERROR: Could not delete report. " . $this->db->error;
            return false;
        }
    }

    // Update an existing report
    function updateReport($repid, $empid, $mesg) {
        $sql = "UPDATE report SET empid = ?, mesg = ? WHERE repid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("isi", $empid, $mesg, $repid);

        if ($stmt->execute()) {
            $this->fillArray(); // Refresh the reports array
            return true;
        } else {
            echo "ERROR: Could not update report. " . $this->db->error;
            return false;
        }
    }

    // Fetch reports by employee ID (Only business owners can see reports of their employees)
    function getReportsByEmployee($empid) {
        $sql = "SELECT * FROM report WHERE empid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $empid); // Bind the empid
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $reports = [];
            while ($row = $result->fetch_assoc()) {
                $reports[] = $row;
            }
            return $reports;
        } else {
            return [];
        }
    }

    // Fetch reports by business owner ID (i.e., all reports from employees under the same business owner)
    function getReportsByBusinessOwner($boid) {
        $sql = "SELECT r.* FROM report r 
                JOIN employee e ON r.empid = e.empid 
                WHERE e.boid = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $boid); // Bind the boid
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $reports = [];
            while ($row = $result->fetch_assoc()) {
                $reports[] = $row;
            }
            return $reports;
        } else {
            return [];
        }
    }
}

?>
