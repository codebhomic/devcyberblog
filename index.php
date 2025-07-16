<?php
session_start();
require_once 'includes/helper.php';
require_once 'includes/db_connect.php';
// Set page title
$page_title = "Home";

// Fetch Featured Posts
$featuredSql = "SELECT b.*, u.full_name AS author_name, c.name AS category_name, c.slug AS category_slug
    FROM blog_articles b
    LEFT JOIN users u ON b.author_id = u.id
    LEFT JOIN blog_categories c ON b.category_id =c.id
    WHERE b.is_featured = 1 AND b.is_published = 1 AND b.is_deleted = 0
    ORDER BY b.id DESC
    LIMIT 5";

$featuredResult = mysqli_query($conn, $featuredSql);

// Fetch All Other Posts
$categorySlug = isset($_GET['category']) ? trim($_GET['category']) : null;

if ($categorySlug) {
    // Prepare query for specific category
    $otherSql = "
        SELECT b.*,
               u.full_name AS author_name,
               c.name AS category_name,
               c.slug AS category_slug
        FROM blog_articles b
        LEFT JOIN blog_categories c ON b.category_id = c.id
        LEFT JOIN users u ON b.author_id = u.id
        WHERE b.is_published = 1 AND c.slug = ? AND b.is_deleted = 0
        ORDER BY b.id DESC
    ";
    $stmt = $conn->prepare($otherSql);
    $stmt->bind_param("s", $categorySlug);
    $stmt->execute();
    $otherResult = $stmt->get_result();
} else {
    // Fetch all posts
    $otherSql = "
        SELECT b.*,
               u.full_name AS author_name,
               c.name AS category_name,
               c.slug AS category_slug
        FROM blog_articles b
        LEFT JOIN blog_categories c ON b.category_id = c.id
        LEFT JOIN users u ON b.author_id = u.id
        WHERE b.is_published = 1 AND b.is_deleted = 0
        ORDER BY b.id DESC
    ";
    $otherResult = mysqli_query($conn, $otherSql);
}

ob_start();
?>

<?php if (!$categorySlug) {?>
<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="max-w-screen-sm text-start mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">
                Recommended Stories</h2>
                <!-- <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">We use an agile approach to test
                    assumptions and connect with the needs of your audience early and often.</p> -->
                </div>
                <?php if ($featuredResult && $featuredResult->num_rows > 0): ?>
            <div class="grid gap-8 md:grid-cols-2 my-8">
                <?php while ($post = $featuredResult->fetch_assoc()): ?>

                    <article class="bg-white dark:bg-gray-900">
                        <div>
                            <img src="<?= get_image_src($post['cover_image_url']) ?>" alt="image" class="h-96 w-full mb-4">
                        </div>
                        <div class="flex justify-between items-center mb-5 text-gray-500">
                            <a href="<?= url_for("categories/".htmlspecialchars($post['category_slug'])); ?>"><span
                                class="bg-indigo-100 capitalize text-indigo-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-800">
                                <?php echo htmlspecialchars($post['category_name']); ?>
                            </span></a>
                            <span class="text-sm">
                                <?php 
                           try {
                               $date = new DateTime(htmlspecialchars($post['updated_at']));
                               echo $date->format('F j, Y');
                           } catch (\Throwable $th) {
                                echo "Very Long Time Ago";
                           }
                            ?></span>
                        </div>
                        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a
                                href="<?php echo url_for("blog/".htmlspecialchars($post['slug'])); ?>">
                                <?php echo htmlspecialchars($post['title']); ?> 
                            </a></h2>
                        <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                            <?php echo htmlspecialchars($post['meta_description']); ?>
                        </p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <!-- <img class="w-7 h-7 rounded-full" src="#" alt="Jese Leos avatar" /> -->
                                <span class="font-medium dark:text-white">
                                    <?php echo htmlspecialchars($post['author_name']); ?>
                                </span>
                            </div>
                            <a href="<?php echo url_for("blog/".htmlspecialchars($post['slug'])); ?>" class="inline-flex items-center font-medium text-indigo-600 dark:text-indigo-500 hover:underline">
                                Read more
                                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-4xl dark:text-white">No featured posts found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php }?>

<section class="bg-white dark:bg-gray-900 min-h-screen">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
        <div class="max-w-screen-sm text-start mb-8">
            <h2 class="mb-4 text-3xl tracking-tight font-extrabold text-gray-900 dark:text-white capitalize">
                Our Blogs <?php if ($categorySlug): ?>for Category <?= str_replace("-", " ",$categorySlug) ?><?php endif;?></h2>
            <!-- <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">We use an agile approach to test
                    assumptions and connect with the needs of your audience early and often.</p> -->
        </div>
        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3 py-8">
            <?php if ($otherResult && $otherResult->num_rows > 0): ?>
                <?php while ($post = $otherResult->fetch_assoc()): ?>
                    <article class="bg-white dark:bg-gray-900">
                        <div>
                            <img src="<?= get_image_src($post['cover_image_url']) ?>" alt="image" class="h-96 w-full mb-4">
                        </div>
                        <div class="flex justify-between items-center mb-5 text-gray-500">
                            <a href="<?= url_for("categories/".$post['category_slug']); ?>"><span
                                class="bg-indigo-100 capitalize text-indigo-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-800">
                                <?php echo htmlspecialchars($post['category_name']); ?>
                            </span></a>
                            <span class="text-sm">
                                <?php 
                           try {
                               $date = new DateTime(htmlspecialchars($post['updated_at']));
                               echo $date->format('F j, Y');
                           } catch (\Throwable $th) {
                                echo "Very Long Time Ago";
                           }
                            ?></span>
                        </div>
                        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a
                                href="<?php echo url_for("blog/".htmlspecialchars($post['slug'])); ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a></h2>
                        <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                            <?php echo htmlspecialchars($post['meta_description']); ?>
                        </p>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-4">
                                <!-- <img class="w-7 h-7 rounded-full" src="#" alt="Jese Leos avatar" /> -->
                                <span class="font-medium dark:text-white">
                                    <?php echo htmlspecialchars($post['author_name']); ?>
                                </span>
                            </div>
                            <a href="<?php echo url_for("blog/".htmlspecialchars($post['slug'])); ?>" class="inline-flex items-center font-medium text-indigo-600 dark:text-indigo-500 hover:underline">
                                Read more
                                <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-4xl dark:text-white">No posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>