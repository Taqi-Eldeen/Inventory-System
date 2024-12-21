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

// Define the password regex (at least 8 characters, 1 special character)
$password_regex = '/^(?=.*[!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?]).{8,}$/';

// Login Logic
if (isset($_POST['login'])) {
    $uname = validate($_POST['uname']);
    $password = validate($_POST['password']);

    if (empty($uname) || empty($password)) {
        header("Location: loginhome.php?error=All fields are required&type=login");
        exit();
    }

    $sql = "SELECT * FROM user WHERE username='$uname'";
 $dbh = DatabaseHandler::getInstance();
    $result = $dbh->query($sql);
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id']; 
            $_SESSION['username'] = $row['username'];
            $_SESSION['type'] = (int)$row['type']; // Ensure type is an integer

            if ($_SESSION['type'] == 1) {
                $supplierId = $controller->getSupplierId($row['id']);
                if ($supplierId) {
                    $_SESSION['supplierid'] = $supplierId;
                } else {
                    $_SESSION['error'] = "Supplier ID not found.";
                }
            }
            
            if ($_SESSION['type'] == 2) {
                $EmployeeId = $controller->getEmployeeId($row['id']);
                if ($EmployeeId) {
                    $_SESSION['empid'] = $EmployeeId;
                } else {
                    $_SESSION['error'] = "Employee ID not found.";
                }
            }
            if ($_SESSION['type'] == 3) {
                $boid = $controller->getBOid($row['id']);
                if ($boid) {
                    $_SESSION['boid'] = $boid;
                } else {
                    $_SESSION['error'] = "BOID not found.";
                }
            }

            switch ($_SESSION['type']) {
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
        try {
            // Use the model method to sign up a business owner
            $userId = $model->signUpBusinessOwner($uname, $email, $password);

            // Store session variables for the newly created user
            $_SESSION['id'] = $userId;
            $_SESSION['username'] = $uname;
            $_SESSION['type'] = 3; // Set type as business owner

            header("Location: Loginhome.php");
            exit();
        } catch (Exception $e) {
            header("Location: loginhome.php?error=" . $e->getMessage() . "&type=signup");
            exit();
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
                    <div class="text-center mt-3">
                <a href="?type=signup" class="btn btn-link"><i>Don't have an account?</i> <b>Signup here</b></a>
            </div>
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
                    <div class="text-center mt-3">
                <a href="?type=login" class="btn btn-link"><i><b>Back to Login</b></i></a>
            </div>
                </form>
            <?php } ?>


        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
