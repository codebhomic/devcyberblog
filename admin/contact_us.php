<?php
session_start();
require_once '../includes/db_connect.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'admin') {
    header('location: ../login.php');
    exit();
}

// Handle reader deletion
if (isset($_POST['delete_query'])) {
    $query_id = $_POST['query_id'];
    $delete_query = "DELETE FROM contact_us WHERE id = $query_id";
    mysqli_query($conn, $delete_query);
    $_SESSION['success'] = "reader Query deleted successfully";
    header('location: contact_us.php');
    exit();
}

// Get all readers (excluding admins)
$readers_query = "SELECT * FROM contact_us ORDER BY created_at DESC";
$readers_result = mysqli_query($conn, $readers_query);

// Get reader statistics
$stats_query = "SELECT 
    COUNT(*) as total_readers,
    COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as new_today,
    COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as new_this_week
    FROM contact_us";
$stats_result = mysqli_query($conn, $stats_query);
$stats = mysqli_fetch_assoc($stats_result);

// Set page title
$page_title = "Manage Readers Query";

// Start output buffering
ob_start();
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Contact Us Forms</h3>
        <p class="text-muted">Manage your Reader Queries Through Contact Form</p>
    </div>
</div>

<?php if (isset($_GET['view'], $_GET['query_id']) && $_GET['view'] === "true" && !empty($_GET['query_id'])) { 
        $query_id = $_GET['query_id'];
        // Get all readers (excluding admins)
        $reader_query = "SELECT * FROM contact_us WHERE id=".$query_id;
        $reader_result = mysqli_query($conn, $reader_query);
        if(mysqli_num_rows($readers_result) > 0) {
            while($reader1 = mysqli_fetch_assoc($reader_result)) {
        ?>
        <div >
        <div class="card animate__animated animate__fadeIn">
            
            <div class="card-body">
                <form action="contactus.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $reader1['fullname']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $reader1['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $reader1['phone']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Created At</label>
                        <input type="text" class="form-control" name="name" value="<?php echo date('M j, Y h:i A', strtotime($reader1['created_at'])); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="text_editor" class="form-control" name="description" rows="3" required><?php echo $reader1['message']; ?></textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php  } } ?>
<?php   } ?>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card animate__animated animate__fadeInUp" style="background: var(--stat-card-1); animation-delay: 0.1s;">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-card-info">
                    <h3><?php echo $stats['total_readers']; ?></h3>
                    <p>Total Readers</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card animate__animated animate__fadeInUp" style="background: var(--stat-card-2); animation-delay: 0.2s;">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <div class="stat-card-info">
                    <h3><?php echo $stats['new_today']; ?></h3>
                    <p>New Today</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="stat-card animate__animated animate__fadeInUp" style="background: var(--stat-card-3); animation-delay: 0.3s;">
            <div class="stat-card-body">
                <div class="stat-card-icon">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-card-info">
                    <h3><?php echo $stats['new_this_week']; ?></h3>
                    <p>New This Week</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card animate__animated animate__fadeIn">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-users me-2"></i>reader Query List</h5>
        <input type="text" id="readersearch" class="form-control form-control-sm" style="width: 200px;" placeholder="Search readers...">
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="readersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($readers_result) > 0) {
                        while($reader = mysqli_fetch_assoc($readers_result)) { 
                            // Get reader's order count
                            $reader_id = $reader['id'];
                            $orders_query = "SELECT COUNT(*) as order_count FROM orders WHERE user_id = $reader_id";
                            $orders_result = mysqli_query($conn, $orders_query);
                            $order_count = mysqli_fetch_assoc($orders_result)['order_count'];
                    ?>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-placeholder me-2"><?php echo substr($reader['fullname'], 0, 1); ?></div>
                                <div><?php echo $reader['fullname']; ?></div>
                            </div>
                        </td>
                        <td><?php echo $reader['email']; ?></td>
                        <td><?php echo $reader['phone']; ?></td>
                        <td><?php echo date('M j, Y', strtotime($reader['created_at'])); ?></td>
                        <td><?php echo date('h:i A', strtotime($reader['created_at'])); ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $reader['id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $reader['id']; ?>">
                                    <li>
                                        <a class="dropdown-item" href="?view=true&query_id=<?php echo $reader['id']; ?>">
                                            <i class="fas fa-shopping-bag me-2"></i>View Query  
                                        </a>
                                    </li>
                                    <li>
                                        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this reader?');">
                                            <input type="hidden" name="query_id" value="<?php echo $reader['id']; ?>">
                                            <button type="submit" name="delete_query" class="dropdown-item text-danger">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-center py-4">No readers found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
.avatar-placeholder {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background-color: var(--primary-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
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

.dropdown-menu {
    background-color: var(--card-bg);
    border-color: var(--border-color);
}

.dropdown-item {
    color: var(--text-color);
}

.dropdown-item:hover {
    background-color: var(--list-group-hover-bg);
    color: var(--primary-color);
}

.dropdown-item.text-danger:hover {
    color: #dc3545 !important;
}
</style>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('readersearch');
    const table = document.getElementById('readersTable');
    const rows = table.querySelectorAll('tbody tr');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        rows.forEach(row => {
            const nameCell = row.querySelector('td:nth-child(1)');
            const emailCell = row.querySelector('td:nth-child(2)');
            const phoneCell = row.querySelector('td:nth-child(3)');
            
            if (!nameCell || !emailCell || !phoneCell) return;
            
            const name = nameCell.textContent.toLowerCase();
            const email = emailCell.textContent.toLowerCase();
            const phone = phoneCell.textContent.toLowerCase();
            
            if (name.includes(searchTerm) || email.includes(searchTerm) || phone.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'admin_layout.php';
?>
