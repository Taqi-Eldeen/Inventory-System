<?php
session_start();
include "../../config/DBConnection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $re_password = validate($_POST['re_password']);

   
    $password_regex = "/^(?=.*[!@#$%^&*(),.?\":{}|<>]).{8,}$/";

    if (empty($uname) || empty($email) || empty($password) || empty($re_password)) {
        header("Location: signuppage.php?error=All fields are required&uname=$uname&email=$email");
        exit();
    } else if (!preg_match($password_regex, $password)) {
        header("Location: signuppage.php?error=Password must be at least 8 characters long and contain at least one special character&uname=$uname&email=$email");
        exit();
    } else if ($password !== $re_password) {
        header("Location: signuppage.php?error=The confirmation password does not match&uname=$uname&email=$email");
        exit();
    } else {

        $sql_check = "SELECT * FROM user WHERE username='$uname' OR email='$email' LIMIT 1";
        $result_check = mysqli_query($conn, $sql_check);

        if (mysqli_num_rows($result_check) > 0) {
            header("Location: signuppage.php?error=The username or email is already taken&uname=$uname&email=$email");
            exit();
        } else {
      
            $password = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO user (username, email, password, type) VALUES('$uname', '$email', '$password', '2')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: loginhome.php?success=Your account has been created successfully");
                exit();
            } else {
                header("Location: signuppage.php?error=Unknown error occurred&uname=$uname&email=$email");
                exit();
            }
        }
    }
} else {
    header("Location: signuppage.php");
    exit();
}
