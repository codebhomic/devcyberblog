<?php
session_start();
require_once '../includes/helper.php';
require_once '../includes/db_connect.php';
// Check if user is logged in and is admin
if (!is_login(true)){
    // header('location: ../login.php?next='.$_SERVER['REQUEST_URI']);
    redirect("login.php?next=".$_SERVER['REQUEST_URI']);
    exit();
}
// Set page title
$page_title = "Dashboard";

// Start output buffering
ob_start();
?>

<!-- Welcome Section -->
<div class="welcome-section animate__animated animate__fadeIn">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3>Welcome, Admin!</h3>
            <p class="text-muted">Here's what's happening with your store today.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <p class="current-date mb-0"><?php echo date('l, F j, Y'); ?></p>
        </div>
    </div>
</div>
<div class="row">
    <!-- Recent Orders -->
    <div class="col-lg-8 mb-4">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- <h5><i class="fas fa-shopping-bag me-2"></i>Recent Orders</h5> -->
                <a href="blog_articles.php" class="btn btn-sm btn-outline-primary">View All Blog</a>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4 mb-4">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-header">
                <h5><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="quick-actions">
                    <a href="add_blog_article.php" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Add New article</h6>
                            <p>Add a new Article to your Blogs</p>
                        </div>
                    </a>
                    <a href="categories.php" class="quick-action-item">
                        <div class="quick-action-icon">
                            <i class="fas fa-tags"></i>
                        </div>
                        <div class="quick-action-text">
                            <h6>Categories</h6>
                            <p>Manage categories</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.welcome-section {
    margin-bottom: 20px;
}

.welcome-section h3 {
    font-weight: 700;
    color: var(--primary-color);
}

.current-date {
    color: var(--primary-color);
    font-weight: 500;
}

.stat-card {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    height: 100%;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.stat-card-body {
    padding: 20px;
    display: flex;
    align-items: center;
}

.stat-card-icon {
    font-size: 2.5rem;
    margin-right: 15px;
    opacity: 0.8;
}

.stat-card-info h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 5px;
    color: white;
}

.stat-card-info p {
    margin-bottom: 0;
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.8);
}

.stat-card-footer {
    padding: 10px 20px;
    background-color: rgba(0, 0, 0, 0.1);
    text-align: right;
}

.stat-card-footer a {
    color: white !important;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.stat-card-footer a:hover {
    opacity: 0.8;
    color: white !important;
}

.quick-actions {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.quick-action-item {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 10px;
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
    text-decoration: none;
    color: var(--text-color);
}

.quick-action-item:hover {
    transform: translateX(5px);
    border-color: var(--primary-color);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.quick-action-item:hover .quick-action-text h6,
.quick-action-item:hover .quick-action-text p {
    color: var(--text-color);
}

.quick-action-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 15px;
}

.quick-action-text h6 {
    margin-bottom: 2px;
    font-weight: 600;
}

.quick-action-text p {
    margin-bottom: 0;
    font-size: 0.85rem;
    opacity: 0.7;
}

@media (max-width: 768px) {
    .stat-card-body {
        padding: 15px;
    }
    
    .stat-card-icon {
        font-size: 2rem;
        margin-right: 10px;
    }
    
    .stat-card-info h3 {
        font-size: 1.5rem;
    }
}
</style>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'admin_layout.php';
?>
