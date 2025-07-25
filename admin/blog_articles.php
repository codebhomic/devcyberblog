<?php
session_start();
require_once '../includes/helper.php';
require_once '../includes/db_connect.php';
// Check if user is logged in and is admin
if (!is_login()){
    // header('location: ../login.php?next='.$_SERVER['REQUEST_URI']);
    redirect("login.php?next=".$_SERVER['REQUEST_URI']);
    exit();
}
$user = get_logged_in_user($conn);
$authorid = $user['id'];
// Handle article deletion
if (isset($_POST['article_delete'])) {
    $article_id = $_POST['article_id'];
    $delete_query = "UPDATE blog_articles SET is_deleted = 1 WHERE id = $article_id AND author_id = $authorid";
    // $delete_query = "DELETE FROM blog_articles WHERE id = $article_id AND author_id = $authorid";
    mysqli_query($conn, $delete_query);
    $_SESSION['success'] = "Request Sent to Delete Article successfully";
    header('location: blog_articles.php');
    exit();
}
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$offset = ($page - 1) * $limit;
// Get all blog articles
$sql = "SELECT 
            a.id, a.title, a.slug, a.is_published, a.created_at,a.published_at,
            c.name AS category_name
        FROM 
            blog_articles a
        LEFT JOIN 
            blog_categories c ON a.id = c.id
        WHERE a.author_id = $authorid AND is_deleted = 0
        ORDER BY 
            a.created_at DESC
        LIMIT $limit OFFSET $offset";
// Now run the query
$articles_results = mysqli_query($conn, $sql);
if(!$articles_results){
    die("<h1 style='text-align: center;font-size: 30px;'>500 Server Error</h1><p style='text-align: center;font-size: 20px'>Unexpected Server Has Occured Please Try Again Later</p>");
}
// Set page title
$page_title = "Manage Blog Articles";
// Start output buffering
ob_start();
?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">All Blog Articles</h3>
        <p class="text-muted">Manage your Blog Articles</p>
    </div>
    <a href="add_blog_article.php" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Blog Article
    </a>
</div>
<div class="card animate__animated animate__fadeIn">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5><i class="fas fa-paint-brush me-2"></i>Blog Articles List</h5>
        <div class="d-flex">
            <input type="text" id="blog_articleSearch" class="form-control form-control-sm me-2" placeholder="Search Blog Articles...">
            <select id="categoryFilter" class="form-select form-select-sm">
                <option value="">All Categories</option>
                <?php
                $cat_query = "SELECT * FROM blog_categories ORDER BY name";
                $cat_result = mysqli_query($conn, $cat_query);
                while ($category = mysqli_fetch_assoc($cat_result)) {
                    echo "<option value='{$category['name']}'>{$category['name']}</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Is Published</th>
                        <th>Published At</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($articles_results) > 0) {
                        while($article = mysqli_fetch_assoc($articles_results)) { 
                    ?>
                    <tr>
                        <td>
                            <h6 class="mb-0"><?=substr($article['title'],0,20); ?></h6>
                        </td>
                        <td>
                            <h6 class="mb-0"><a href="<?= url_for("blog/".$article['slug']) ?>" target="_blank" rel="noopener noreferrer"><?=substr($article['slug'],0,20); ?></a></h6>
                        </td>
                        <td><?= $article['is_published'] ? "Yes" : "No"; ?></td>
                        <td><?= $article['is_published'] ? $article['published_at'] : "Not Published" ; ?></td>
                        <td><?= $article['created_at']; ?></td>
                        <td>
                            <a href="edit_blog_article.php?id=<?=$article['id']; ?>" 
                               class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="blog_articles.php" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to request for deleting article?');">
                                <input type="hidden" name="article_id" value="<?=$article['id']; ?>">
                                <button type="submit" name="article_delete" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php 
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">No Blog Articles found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
/*.blog_article-image {*/
/*    width: 60px;*/
/*    height: 60px;*/
/*    object-fit: cover;*/
/*    border: 1px solid var(--border-color);*/
/*    transition: all 0.3s ease;*/
/*}*/

/*.blog_article-image:hover {*/
/*    transform: scale(1.1);*/
/*    box-shadow: 0 5px 15px rgba(0,0,0,0.1);*/
/*}*/
</style> 
<?php $content = ob_get_clean(); // Get the buffered content?>
<?php include 'admin_layout.php'; // Include the layout ?>