<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
include "../DBConnection.php";


if (!isset($_SESSION['username']) || $_SESSION['type'] != 1) {
    header("Location: ../loginhome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../sidebar.css">
    <style>
        
        .notification-bell {
            position: relative;
        }
        .notification-bell .badge {
            position: absolute;
            top: 0;
            right: 0;
            padding: 3px 6px;
            border-radius: 50%;
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
  
  <main class="d-flex flex-nowrap">
        
  
    <div class="d-flex flex-column flex-shrink-0 p-3 sidebar">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4">Supplier Dashboard</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto" id="sidebar-nav">
            <li>
                <a href="supplierdashboard.php" class="nav-link text-white"><i class="fa-solid fa-gauge-high"></i> Dashboard</a>
            </li>
            
            <li>
                <a href="editproduct.php" class="nav-link text-white"><i class="fa-solid fa-pen-to-square"></i>Manage Products</a>
            </li>
            <li>
                <a href="addproduct.php" class="nav-link text-white"><i class="fa-solid fa-plus"></i> Add Product</a>
            </li>
            <li>
                <a href="trackmovement.php" class="nav-link text-white"><i class="fa-solid fa-chart-line"></i> Track Movement</a>
            </li>
            
        </ul>
        <hr>
        <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="../images/user.jpg" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong><?php echo $_SESSION['username']; ?></strong> 
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="../profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="../signout.php"><i class="fa-solid fa-right-from-bracket"></i>Sign out</a></li>
                </ul>
            </div>
        </div>
    

    <div class="flex-grow-1 d-flex flex-column" style="margin-left: 280px;">
        <nav class="navbar search-nav">
            <div class="container-fluid justify-content-end">
        
                <div class="notification-bell me-4">
                    <a href="#" class="text-white">
                        <i class="fa-solid fa-bell fa-lg"></i>
                        <span class="badge">2</span> 
                    </a>
                </div>
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </nav>
    </div>
    
  </main>
  
  
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
