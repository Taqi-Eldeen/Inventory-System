<?php
session_start();

define('__ROOT__', "../app/");
require_once(__ROOT__ . "model/Users.php");
require_once(__ROOT__ . "controller/UserController.php");

$model = new Users();
$controller = new UsersController($model);

// Login Logic
if (isset($_POST['login'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname) || empty($password)) {
        header("Location: loginhome.php?error=All fields are required&type=login");
        exit();
    }

    $sql = "SELECT * FROM user WHERE username='$uname'";
    $dbh = new Dbh();
    $result = $dbh->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['ID'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['type'] = $row['type'];

            switch ($row['type']) {
                case 0:
                    header("Location: ../app/Views/Admin/admin.php");
                    break;
                case 1:
                    header("Location:../app/Views/Supplier/supplierdashboard.php");
                    break;
                case 2:
                    header("Location: ../app/Views/User/dashboard.php");
                    break;
            }
            exit();
        } else {
            header("Location: loginhome.php?error=Incorrect username or password&type=login");
            exit();
        }
    } else {
        header("Location: loginhome.php?error=User not found&type=login");
        exit();
    }
}

// Signup Logic
if (isset($_POST['signup'])) {
    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $re_password = validate($_POST['re_password']);

    $password_regex = "/^(?=.*[!@#$%^&*(),.?\":{}|<>]).{8,}$/" ;

    if (empty($uname) || empty($email) || empty($password) || empty($re_password)) {
        header("Location: loginhome.php?error=All fields are required&type=signup");
        exit();
    } elseif (!preg_match($password_regex, $password)) {
        header("Location: loginhome.php?error=Password must be 8+ characters with 1 special character&type=signup");
        exit();
    } elseif ($password !== $re_password) {
        header("Location: loginhome.php?error=Passwords do not match&type=signup");
        exit();
    } else {
        $dbh = new Dbh();
        $sql_check = "SELECT * FROM user WHERE username='$uname' OR email='$email'";
        $result_check = $dbh->query($sql_check);

        if ($result_check->num_rows > 0) {
            header("Location: loginhome.php?error=Username or Email already exists&type=signup");
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, email, password, type) VALUES('$uname', '$email', '$hashed_password', '2')";

            if ($dbh->query($sql)) {
                // Log the user in immediately after signup
                $sql = "SELECT * FROM user WHERE username='$uname' AND email='$email'";
                $result = $dbh->query($sql);
                $user = $result->fetch_assoc();
                $_SESSION['ID'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['type'] = $user['type'];

                // Redirect based on user type
                switch ($user['type']) {
                    case 0:
                        header("Location: /app/Views/Admin/admin.php");
                        break;
                    case 1:
                        header("Location: ../Supplier/supplierdashboard.php");
                        break;
                    case 2:
                        header("Location: ../User/dashboard.php");
                        break;
                }
                exit();
            } else {
                header("Location: loginhome.php?error=Database error&type=signup");
                exit();
            }
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login & Signup</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="stylesheet" type="text/css" href="css/signup.css">
    <style>
        body { font-family: Arial, sans-serif; }
        .container { display: flex; justify-content: center; margin-top: 50px; }
        .form-container { width: 400px; }
        .tabs { display: flex; justify-content: space-around; }
        .tabs a { text-decoration: none; font-weight: bold; color: #333; padding: 10px; }
        .active { border-bottom: 2px solid #000; }
        .error, .success { color: red; text-align: center; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="tabs">
                <a href="?type=login" class="<?php echo (!isset($_GET['type']) || $_GET['type'] == 'login') ? 'active' : ''; ?>">Login</a>
                <a href="?type=signup" class="<?php echo (isset($_GET['type']) && $_GET['type'] == 'signup') ? 'active' : ''; ?>">Signup</a>
            </div>
            
            <?php if (!isset($_GET['type']) || $_GET['type'] == 'login') { ?>
                <!-- Login Form -->
                <form action="loginhome.php" method="post">
                    <h2>Login</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php } ?>
                    <label>Username</label>
                    <input type="text" name="uname" placeholder="User Name" required><br>
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <button type="submit" name="login">Login</button>
                </form>
            <?php } else { ?>
                <!-- Signup Form -->
                <form action="loginhome.php" method="post">
                    <h2>Signup</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <?php } elseif (isset($_GET['success'])) { ?>
                        <p class="success"><?php echo htmlspecialchars($_GET['success']); ?></p>
                    <?php } ?>
                    <label>Username</label>
                    <input type="text" name="uname" placeholder="User Name" required><br>
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Email" required><br>
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Password" required><br>
                    <label>Re-enter Password</label>
                    <input type="password" name="re_password" placeholder="Re-enter Password" required><br>
                    <button type="submit" name="signup">Signup</button>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>

