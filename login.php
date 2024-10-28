<?php
session_start();
include "DBConnection.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: loginhome.php?error=User Name is required");
        exit();
    } else if (empty($password)) {
        header("Location: loginhome.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM user WHERE username='$uname'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                $_SESSION['type'] = $row['type']; 
                
                switch ($row['type']) {
                    case 0:
                        header("Location: admin/admin.php");
                        break;
                    case 1:
                        header("Location: supplier/addproduct.php");
                        break;
                    case 2:
                        header("Location: dashboard.php");
                        break;
                    default:
                        header("Location: loginhome.php?error=Unauthorized access");
                        break;
                }
                exit();
            } else {
                header("Location: loginhome.php?error=Incorrect username or password");
                exit();
            }
        } else {
            header("Location: loginhome.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header("Location: loginhome.php");
    exit();
}
