<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}
if (!isset($_SESSION['username'])) {
    header("Location: loginhome.php");
    exit();
}
require_once(dirname(__FILE__) . '/../../model/Pages.php');
require_once(dirname(__FILE__) . '/../../model/Page.php');
$userType = $_SESSION['type'];
$pagesClass = new Pages($userType);
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
            <ul class="nav nav-pills flex-column mb-auto" id="sidebar-nav">
                <?php foreach($pagesClass->pages as $page) : ?>
                    <li>
                        <a href="<?php echo $page->pageName ?>" class="nav-link text-white">
                            <i class="fa-solid fa-table-columns"></i><?php echo $page->title ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <hr>
        </div>
        
        <div class="flex-grow-1 d-flex flex-column" style="margin-left: 15%;">
            <nav class="navbar search-nav">
                <div class="container-fluid justify-content-end">
                    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-4">
                            <?php
                            switch($userType) {
                                case 0:
                                    echo "Admin Dashboard";
                                    break;
                                case 3:
                                    echo "Owner Dashboard";
                                    break;
                                case 1:
                                    echo "Supplier Dashboard";
                                    break;
                                default:
                                    echo "Employee Dashboard";
                            }
                            ?>
                        </span>
                    </a>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="" width="32" height="32" class="rounded-circle me-2">
                            <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                            <li><a class="dropdown-item" href="../../../public/loginhome.php"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
                        </ul>
                    </div>
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
