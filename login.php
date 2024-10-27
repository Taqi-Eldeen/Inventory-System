<?php
session_start();
include "db_conn.php";

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
        $sql = "SELECT * FROM users WHERE username='$uname'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: loginhome.php?error=Incorrect User name or password");
                exit();
            }
        } else {
            header("Location: loginhome.php?error=Incorrect User name or password");
            exit();
        }
    }
} else {
    header("Location: loginhome.php");
    exit();
}
