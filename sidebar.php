<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="sidebar.css">
</head>
<body>
  
  <main class="d-flex flex-nowrap">      
  <div class="d-flex flex-column flex-shrink-0 p-3 sidebar">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4">User Dashboard</span>
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto" id="sidebar-nav">
                <li>
                    <a href="dashboard.php" class="nav-link text-white"><i class="fa-solid fa-table-columns"></i> Dashboard</a>
                </li>
                <li>
                    <a href="products.php" class="nav-link text-white"><i class="fa-solid fa-cubes"></i> Stock</a>
                </li>
                <li>
                    <a href="customers.php" class="nav-link text-white"><i class="fa-solid fa-truck-ramp-box"></i> Suppliers</a>
                </li>
                <li>
                    <a href="logs.php" class="nav-link text-white"><i class="fa-solid fa-file-waveform"></i> Logs</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#"> New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#"><i class="fa-solid fa-right-from-bracket"></i> Sign out</a></li>
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
        const burgerMenu = document.querySelector('.burger-menu');
const sidebar = document.querySelector('.sidebar');
const mainContent = document.querySelector('.main-content');

burgerMenu.addEventListener('click', () => {
    burgerMenu.classList.toggle('active');
    sidebar.classList.toggle('active');
    mainContent.classList.toggle('active');
});
    </script>
</body>
</html>
