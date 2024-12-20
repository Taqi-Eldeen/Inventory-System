<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
if (!isset($_SESSION['username'])) {
    header("Location: loginhome.php");
    exit();
}

// Check user type
$userType = $_SESSION['type'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../../public/css/sidebar.css">
</head>
<body>
  
  <main class="d-flex flex-nowrap">      
  <div class="d-flex flex-column flex-shrink-0 p-3 sidebar">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">
                    <?php
                    // Display dashboard title based on user type
                    if ($userType == 0) {
                        echo "Admin Dashboard";
                    } elseif ($userType == 3) { // Owner
                        echo "Owner Dashboard";
                    } elseif ($userType == 1) { // Supplier
                        echo "Supplier Dashboard";
                    } else { // User
                        echo "User Dashboard";
                    }
                    ?>
                </span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebar-nav">
                <?php if ($userType == 0): // Admin ?>
                    <li>
                        <a href="admin.php" class="nav-link text-white"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="manageusers.php" class="nav-link text-white"><i class="fa-solid fa-users-gear"></i> Manage Users</a>
                    </li>
                    <li>
                        <a href="addusers.php" class="nav-link text-white"><i class="fa-solid fa-user-plus"></i> Add Users</a>
                    </li>
                <?php elseif ($userType == 3): // Owner ?>
                    <li>
                        <a href="Ownerdashboard.php" class="nav-link text-white"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="managesupply.php" class="nav-link text-white"><i class="fa-solid fa-truck"></i> Manage Suppliers</a>
                    </li>
                    <li>
                        <a href="manageemployee.php" class="nav-link text-white"><i class="fa-solid fa-user-plus"></i> Manage Employees</a>
                    </li>
                    <li>
                        <a href="manageinventory.php" class="nav-link text-white"><i class="fa-solid fa-briefcase"></i> Manage Inventory</a>
                    </li>
                    <li>
                        <a href="reports.php" class="nav-link text-white"><i class="fa-solid fa-chart-line"></i> Reports</a>
                    </li>
                <?php elseif ($userType == 1): // Supplier ?>
                    <li>
                        <a href="supplierdashboard.php" class="nav-link text-white"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="editproduct.php" class="nav-link text-white"><i class="fa-solid fa-pen-to-square"></i> Manage Products</a>
                    </li>
                    <li>
                        <a href="addproduct.php" class="nav-link text-white"><i class="fa-solid fa-plus"></i> Add Product</a>
                    </li>
                    <li>
                        <a href="trackmovement.php" class="nav-link text-white"><i class="fa-solid fa-chart-line"></i> Track Movement</a>
                    </li>
                <?php else: // User ?>
                    <li>
                        <a href="dashboard.php" class="nav-link text-white"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="products.php" class="nav-link text-white"><i class="fa-solid fa-cubes"></i> Stock</a>
                    </li>
                    <li>
                        <a href="availablesuppliers.php" class="nav-link text-white"><i class="fa-solid fa-truck-ramp-box"></i> Suppliers</a>
                    </li>
                    <li>
                        <a href="logs.php" class="nav-link text-white"><i class="fa-solid fa-file-waveform"></i> Logs</a>
                    </li>
                <?php endif; ?>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="images/user.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../auth/signout.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                </ul>
            </div>
        </div>
        
        <div class="flex-grow-1 d-flex flex-column" style="margin-left: 280px;">
        <nav class="navbar search-nav">
            <div class="container-fluid justify-content-end">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
    
  </main>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentPage = window.location.pathname.split('/').pop();
        const sidebarNav = document.getElementById('sidebar-nav');
        const links = sidebarNav.getElementsByTagName('a');

        for (let link of links) {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('active');
                link.classList.remove('text-white');
                link.setAttribute('aria-current', 'page');
            } else {
                link.classList.remove('active');
                link.classList.add('text-white');
                link.removeAttribute('aria-current');
            }
        }
    });
  </script>
</body>
</html>
