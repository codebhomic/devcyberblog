<?php
session_start();
require_once '../includes/helper.php';
require_once '../includes/db_connect.php';

// Check if user is logged in and is admin
if (!is_login(true)){
    $_SESSION["message"] = "User is already Login";
    redirect("admin/dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET["id"])) {
    // Get blog_categories for dropdown
    $stmt = $conn->prepare("SELECT * FROM blog_articles WHERE id = ?");
    $stmt->bind_param("i", $_GET["id"]);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if (!$row) {
            $_SESSION['error'] = "Article with the " . $_GET["id"] . " id does not exist";
            header('location: blog_articles.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Article with the " . $_GET["id"] . " id does not exist";
        header('location: blog_articles.php');
        exit();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data from admin POST request
    $title = $_POST['title'];
    $slug = $_POST['slug']; // You can also auto-generate from title
    $content = $_POST['content'];
    $cover_image_url = $_POST['cover_image_url'];
    $author_id = $_SESSION['user_id'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $category_id = $_POST['category_id'] ?? null;
    $published_at = $is_published ? date('Y-m-d H:i:s') : null;
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("
    UPDATE blog_articles SET
        title = ?, 
        slug = ?, 
        content = ?, 
        cover_image_url = ?, 
        meta_title = ?, 
        meta_description = ?, 
        is_published = ?, 
        is_featured = ?, 
        category_id = ?, 
        published_at = ?, 
        updated_at = ?
    WHERE id = ?
");

$stmt->bind_param(
    "ssssssiiissi",
    $title,
    $slug,
    $content,
    $cover_image_url,
    $meta_title,
    $meta_description,
    $is_published,
    $is_featured,
    $category_id,
    $published_at,
    $now,
    $_GET["id"]
);

    print_r1($stmt);
    print_r1($author_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = isset($_POST['is_published']) ? "Article is published And Updated successfully" : "Article is saved to drafts and updated successfully";
        header('location: blog_articles.php');
        exit();
    } else {
        $error = "Error adding Article: " . mysqli_error($conn);
    }
} else {
    error_page(404);
    exit();
}

// Get blog_categories for dropdown
$blog_categories_query = "SELECT * FROM blog_categories ORDER BY name";
$blog_categories_result = mysqli_query($conn, $blog_categories_query);

// Set page title
$page_title = "Edit Blog Article";

// Start output buffering
ob_start();
?>
<link rel="stylesheet" href="../richtexteditor/rte_theme_default.css" />
<script type="text/javascript" src="../richtexteditor/rte.js"></script>
<script type="text/javascript" src='../richtexteditor/plugins/all_plugins.js'></script>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Edit Blog Article</h3>
        <p class="text-muted">Edit Blog Article</p>
    </div>
    <a href="blog_articles.php" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Blog Articles
    </a>
</div>

<?php if (isset($error)) { ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<div class="row">
    <div class="col-xl-9">
        <div class="card animate__animated animate__fadeIn">
            <div class="card-header">
                <h5><i class="fas fa-edit me-2"></i>Blog Article</h5>
            </div>
            <div class="card-body">
                <form method="POST" id="ArticleForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Article Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= $row['title'] ?>"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Article Category</label>
                            <select class="form-select" name="category_id" required>
                                <option value="">Select Category</option>
                                <?php while ($category = mysqli_fetch_assoc($blog_categories_result)) { ?>
                                    <option value="<?php echo $category['id']; ?>" <?= $category['id'] == $row['category_id'] ? "selected" : "" ?>>
                                        <?php echo $category['name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3" style="overflow-x: scroll;">
                        <label class="form-label">Article</label>
                        <textarea id="edit_description" class="form-control" name="content" rows="4"
                            required><?= $row['content'] ?></textarea>
                        <small class="text-muted">Provide a detailed Article for blog</small>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Slug</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="slug" id="slug" value="<?= $row['slug'] ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Image URL</label>
                            <input type="url" value="<?= $row['cover_image_url'] ?>" class="form-control"
                                name="cover_image_url" id="imageUrl" required>
                            <small class="text-muted">Enter a valid image URL</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="card animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
            <div class="card-header">
                <h5><i class="fas fa-image me-2"></i>SEO & Publishing</h5>
            </div>
            <div class="card-body">
                <!-- Meta Title -->
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" form="ArticleForm" id="meta_title" name="meta_title"
                        value="<?= $row['meta_title'] ?>" placeholder="Enter meta title">
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" form="ArticleForm" id="meta_description" name="meta_description"
                        rows="3"
                        placeholder="Write a brief meta description..."><?= $row['meta_description'] ?></textarea>
                </div>

                <!-- Is Published Checkbox -->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" form="ArticleForm" id="is_published"
                        <?= $row['is_published'] ? "checked" : "" ?> name="is_published">
                    <label class="form-check-label" for="is_published">Publish Now</label>
                </div>

                <!-- Is Featured Checkbox -->
                <div class="form-check form-switch mb-2">
                    <input class="form-check-input" type="checkbox" form="ArticleForm" id="is_featured"
                        <?= $row['is_featured'] ? "checked" : "" ?> name="is_featured">
                    <label class="form-check-label" for="is_featured">Mark as Featured</label>
                </div>
            </div>
        </div>

        <div class="card animate__animated animate__fadeIn" style="animation-delay: 0.1s;">
            <div class="card-header">
                <h5><i class="fas fa-image me-2"></i>Image Preview</h5>
            </div>
            <div class="card-body text-center">
                <div class="image-preview mb-3">
                    <img id="previewImage" src="<?= get_image_src($row['cover_image_url']) ?>" class="img-fluid rounded"
                        alt="Article Preview">
                </div>
                <p class="text-muted small">Preview of your Article image</p>
            </div>
        </div>

        <div class="card mt-4 animate__animated animate__fadeIn" style="animation-delay: 0.2s;">
            <div class="card-header">
                <h5><i class="fas fa-save me-2"></i>Save</h5>
            </div>
            <div class="card-body">
                <button type="submit" form="ArticleForm" class="btn btn-primary w-100 mb-3">
                    <i class="fas fa-plus-circle me-2"></i>Add Article
                </button>
                <a href="Articles.php" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-times-circle me-2"></i>Cancel
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .image-preview {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 10px;
        background-color: var(--bg-color);
        transition: all 0.3s ease;
    }

    .image-preview img {
        max-height: 250px;
        object-fit: contain;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .input-group-text {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const imageUrlInput = document.getElementById('imageUrl');
        const previewImage = document.getElementById('previewImage');

        // Update image preview when URL changes
        imageUrlInput.addEventListener('input', function () {
            const url = this.value.trim();
            if (url) {
                previewImage.src = url;
                previewImage.onerror = function () {
                    previewImage.src = 'https://dummyimage.com/300x300/000/fff?text=Invalid+Image+URL';
                };
            } else {
                previewImage.src = 'https://dummyimage.com/300x300/000/fff?text=Article+Image';
            }
        });
    });
    function slugify(text) {
        return text
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9\s-]/g, '')     // remove invalid chars
            .replace(/\s+/g, '-')             // collapse whitespace and replace by -
            .replace(/-+/g, '-');             // collapse dashes
    }

    document.getElementById("title").addEventListener("input", function () {
        const rawTitle = this.value;
        const random = Math.floor(Math.random() * (100000 - 10000)) + 10000;
        const slug = slugify(rawTitle) + "-" + random;
        document.getElementById("slug").value = slug;
    });
    var editor1 = new RichTextEditor("#edit_description");
</script>
<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'admin_layout.php';
?>