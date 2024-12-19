<?php
session_start();  // Start the session to store session variables

define('__ROOT__', "../app/");  // Set root directory for include paths
require_once(__ROOT__ . "Config/DBConnection.php");  
require_once(__ROOT__ . "model/Users.php");
require_once(__ROOT__ . "controller/UserController.php");

$model = new Users();
$controller = new UsersController($model);

// Function to validate inputs
function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Login Logic
if (isset($_POST['login'])) {
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname) || empty($password)) {
        header("Location: loginhome.php?error=All fields are required&type=login");
        exit();
    }

    $sql = "SELECT * FROM user WHERE username='$uname'";
    $dbh = new DatabaseHandler();
    $result = $dbh->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id']; 
            $_SESSION['username'] = $row['username'];
            $_SESSION['type'] = $row['type']; 

            if ($row['type'] == 1) {
                $supplierId = $controller->getSupplierId($row['id']);
                if ($supplierId) {
                    $_SESSION['supplierid'] = $supplierId;
                } else {
                    $_SESSION['error'] = "Supplier ID not found.";
                }
            }

            switch ($row['type']) {
                case 0:
                    header("Location: ../app/Views/Admin/admin.php");
                    break;
                case 1:
                    header("Location: ../app/Views/Supplier/supplierdashboard.php");
                    break;
                case 2:
                    header("Location: ../app/Views/User/dashboard.php");
                    break;
                case 3:
                    header("Location: ../app/Views/Owner/ownerdashboard.php");
                    break;
                default:
                    header("Location: loginhome.php?error=Invalid user type&type=login");
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
    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $re_password = validate($_POST['re_password']);

    $password_regex = "/^(?=.*[!@#$%^&*(),.?\":{}|<>]).{8,}$/";

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
        $dbh = new DatabaseHandler();
        $sql_check = "SELECT * FROM user WHERE username='$uname' OR email='$email'";
        $result_check = $dbh->query($sql_check);

        if ($result_check->num_rows > 0) {
            header("Location: loginhome.php?error=Username or Email already exists&type=signup");
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO user (username, email, password, type) VALUES('$uname', '$email', '$hashed_password', '3')";

            if ($dbh->query($sql)) {
                $sql = "SELECT * FROM user WHERE username='$uname' AND email='$email'";
                $result = $dbh->query($sql);
                $user = $result->fetch_assoc();

                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['type'] = $user['type'];

                // Insert into the 'owner' table
                $ownerSql = "INSERT INTO owner (user_id) VALUES ('" . $user['id'] . "')";
                $dbh->query($ownerSql); // Insert into the owner table

                switch ($user['type']) {
                    case 0:
                        header("Location: ../app/Views/Admin/admin.php");
                        break;
                    case 1:
                        header("Location: ../app/Views/Supplier/supplierdashboard.php");
                        break;
                    case 2:
                        header("Location: ../app/Views/User/dashboard.php");
                        break;
                    case 3:
                        header("Location: ../app/Views/Owner/ownerdashboard.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/loginhome.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="form-container w-50">
            <div class="button-background">
                <div class="tabs mb-3">
                    <a href="?type=login" class="btn btn-black <?php echo (!isset($_GET['type']) || $_GET['type'] == 'login') ? 'active' : ''; ?>">Login</a>
                    <a href="?type=signup" class="btn btn-black <?php echo (isset($_GET['type']) && $_GET['type'] == 'signup') ? 'active' : ''; ?>">Signup</a>
                </div>
            </div>
            
            <?php if (!isset($_GET['type']) || $_GET['type'] == 'login') { ?>
                <form action="loginhome.php" method="post" class="border p-4 rounded bg-light">
                    <h2 class="text-center">Login</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="uname" class="form-control" placeholder="User Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-black">Login</button>
                </form>
            <?php } else { ?>
                <form action="loginhome.php" method="post" class="border p-4 rounded bg-light">
                    <h2 class="text-center">Signup</h2>
                    <?php if (isset($_GET['error'])) { ?>
                        <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
                    <?php } elseif (isset($_GET['success'])) { ?>
                        <div class="alert alert-success"><?php echo htmlspecialchars($_GET['success']); ?></div>
                    <?php } ?>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="uname" class="form-control" placeholder="User Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Re-enter Password</label>
                        <input type="password" name="re_password" class="form-control" placeholder="Re-enter Password" required>
                    </div>
                    <button type="submit" name="signup" class="btn btn-black">Signup</button>
                </form>
            <?php } ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
