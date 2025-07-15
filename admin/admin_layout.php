    <?php
require_once "../includes/helper.php";
// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('location: ../login.php');
    exit();
}

// Set the active page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Art Delivery Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="<?= url_for("static/css/admin.css")?>">
    <link rel="stylesheet" href="../richtexteditor/rte_theme_default.css" />
<script type="text/javascript" src="../richtexteditor/rte.js"></script>
<script type="text/javascript" src='../richtexteditor/plugins/all_plugins.js'></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2 col-md-3 px-0 sidebar" id="sidebar">
                <div class="logo-wrapper">
                    <i class="fas fa-paint-brush logo-icon"></i>
                    <h5>Admin Panel</h5>
                </div>
                <div class="nav-container">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'blog_articles.php' || $current_page == 'add_blog_article.php' || $current_page == 'edit_blog_article.php' ? 'active' : ''; ?>" href="blog_articles.php">
                                <i class="fas fa-paint-brush"></i> Blog Articles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'categories.php' ? 'active' : ''; ?>" href="categories.php">
                                <i class="fas fa-list"></i> Categories
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'contact_us.php' ? 'active' : ''; ?>" href="contact_us.php">
                                 <i class="fa-solid fa-user"></i> Customer Requests
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>" href="settings.php">
                                <i class="fas fa-gear"></i> Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 col-md-9 main-content">
                <div class="admin-header">
                    <span class="mobile-toggle" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </span>
                    <h2><?php echo $page_title; ?></h2>
                    <div class="theme-switch-wrapper">
                        <span class="theme-text">Light</span>
                        <label class="theme-switch" for="checkbox">
                            <input type="checkbox" id="checkbox" checked />
                            <div class="slider">
                                <div class="slider-icons">
                                    <i class="fas fa-sun"></i>
                                    <i class="fas fa-moon"></i>
                                </div>
                            </div>
                        </label>
                        <span class="theme-text">Dark</span>
                    </div>
                    <div class="nav-item">
                            <a class="btn btn-primary mx-4 <?= $current_page == 'settings.php' ? 'active' : ''; ?>" href="<?= SITE_URL ?>">
                                View Site
                            </a>
</div>
                </div>

                <?php if(isset($_SESSION['success'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php } ?>
                <?php if(isset($_SESSION['error'])) { ?>
                    <div class="alert alert-dismissible fade show" style="color:white; background-color:red;">
                        <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php } ?>

                <!-- Main content will be here -->
                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check for saved theme preference or use default dark theme
            const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : 'dark';
            
            // Apply the saved theme on page load
            document.documentElement.setAttribute('data-theme', currentTheme);
            
            // Update checkbox state based on current theme
            const themeCheckbox = document.getElementById('checkbox');
            if (themeCheckbox) {
                themeCheckbox.checked = currentTheme === 'dark';
                
                // Theme toggle functionality
                themeCheckbox.addEventListener('change', function() {
                    const newTheme = this.checked ? 'dark' : 'light';
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                    
                    // Dispatch a custom event for other scripts to listen to
                    document.dispatchEvent(new CustomEvent('themeChanged', { 
                        detail: { theme: newTheme } 
                    }));
                });
            }
            
            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    document.getElementById('sidebar').classList.toggle('show');
                });
            }
            
            // Apply theme to any dynamically loaded content
            applyThemeToElements();
        });
        
        // Function to apply theme to specific elements that might need special handling
        function applyThemeToElements() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            
            // Apply theme to status badges
            document.querySelectorAll('.badge').forEach(badge => {
                if (currentTheme === 'dark') {
                    // Ensure badges are visible in dark mode
                    if (badge.classList.contains('bg-light')) {
                        badge.classList.remove('bg-light');
                        badge.classList.add('bg-secondary');
                    }
                }
            });
            
            // Apply theme to tables
            document.querySelectorAll('table').forEach(table => {
                if (currentTheme === 'dark') {
                    table.classList.add('table-dark');
                } else {
                    table.classList.remove('table-dark');
                }
            });
        }
        
        // Listen for theme changes
        document.addEventListener('themeChanged', function(e) {
            applyThemeToElements();
        });
    </script>
</body>
</html> 