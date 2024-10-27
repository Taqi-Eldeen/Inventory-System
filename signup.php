<?php
session_start();
include "db_conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $name = validate($_POST['name']);
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $re_password = validate($_POST['re_password']);

    if (empty($name) || empty($uname) || empty($email) || empty($password) || empty($re_password)) {
        header("Location: signuppage.php?error=All fields are required&name=$name&uname=$uname&email=$email");
        exit();
    } else if ($password !== $re_password) {
        header("Location: signuppage.php?error=The confirmation password does not match&name=$name&uname=$uname&email=$email");
        exit();
    } else {
        // Hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name, username, email, password) VALUES('$name', '$uname', '$email', '$password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header("Location: loginhome.php?success=Your account has been created successfully");
            exit();
        } else {
            header("Location: signuppage.php?error=Unknown error occurred&name=$name&uname=$uname&email=$email");
            exit();
        }
    }
} else {
    header("Location: signuppage.php");
    exit();
}
