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
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: loginhome.php?error=User Name is required");
        exit();
    } else if (empty($pass)) {
        header("Location: loginhome.php?error=Password is required");
        exit();
    } else {
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM users WHERE user_name = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $uname, $pass);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['id'] = $row['id'];
                header("Location: home.php");
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
