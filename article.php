<?php
session_start();
require_once 'includes/helper.php';
// Include DB connection
require_once 'includes/db_connect.php';

// Get the slug safely from $_GET
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

if (!preg_match('/^[a-z0-9-]+$/', $slug)) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Bad Request");
    error_page("404");
    exit();
}

// Validate slug (basic)
if (!$slug) {
    header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
    error_page("404");
    exit();
}

// Prepare statement
$stmt = mysqli_prepare($conn, "
    SELECT 
        b.*, 
        u.full_name AS author_name, 
        c.name AS category_name, 
        c.id AS category_id, 
        c.slug AS category_slug
    FROM blog_articles b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN users u ON b.author_id = u.id
    WHERE b.slug = ? AND b.is_published = 1
    LIMIT 1
");

if (!$stmt) {
    die("Prepare failed: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);

$article_results = mysqli_stmt_get_result($stmt);
$post = mysqli_fetch_assoc($article_results);
$cid = $post['category_id'];
if (!$post) {
    header($_SERVER["SERVER_PROTOCOL"] . " 400 Bad Request");
    error_page("404");
    exit();
}

// Set page title
$page_title = $post['title'];
ob_start();
?>
<style>
    #content h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 1.2em 0 0.5em;
    }

    #content h2 {
        font-size: 1.75rem;
        font-weight: 600;
        margin: 1em 0 0.5em;
    }

    #content h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin: 1em 0 0.5em;
    }

    #content p {
        margin: 0.75em 0;
        line-height: 1.7;
    }

    #content ul {
        list-style-type: disc;
        padding-left: 1.5em;
        margin: 0.75em 0;
    }

    #content ol {
        list-style-type: decimal;
        padding-left: 1.5em;
        margin: 0.75em 0;
    }

    #content a {
        color: #3b82f6;
        /* Tailwind blue-500 */
        text-decoration: underline;
    }

    #content blockquote {
        border-left: 4px solid #d1d5db;
        /* Tailwind gray-300 */
        padding-left: 1em;
        color: #374151;
        /* Tailwind gray-700 */
        font-style: italic;
        margin: 1em 0;
    }

    #content img {
        max-width: 100%;
        height: auto;
    }

    #content pre {
        background: #f3f4f6;
        /* Tailwind gray-100 */
        padding: 1em;
        border-radius: 0.375rem;
        overflow-x: auto;
    }

    #content code {
        background: #f3f4f6;
        padding: 0.2em 0.4em;
        border-radius: 0.25rem;
    }

    /* 🌙 Dark Mode Styles */
    .dark #content {
        color: #d1d5db;
        /* Tailwind gray-300 */
    }

    .dark #content h1,
    .dark #content h2,
    .dark #content h3 {
        color: #f9fafb;
        /* Tailwind gray-50 */
    }

    .dark #content p {
        color: #d1d5db;
        /* Tailwind gray-300 */
    }

    .dark #content a {
        color: #60a5fa;
        /* Tailwind blue-400 */
    }

    .dark #content blockquote {
        border-left-color: #4b5563;
        /* Tailwind gray-600 */
        color: #9ca3af;
        /* Tailwind gray-400 */
    }

    .dark #content pre {
        background: #374151;
        /* Tailwind gray-700 */
    }

    .dark #content code {
        background: #4b5563;
        /* Tailwind gray-600 */
        color: #f3f4f6;
        /* Light text in code */
    }
</style>
<main class="pt-8 pb-16 lg:pt-16 lg:pb-24 bg-white dark:bg-gray-900 antialiased">
    <div class="px-4 mx-auto max-w-screen-2xl flex flex-col md:flex-row justify-center">
        <article class="format format-sm sm:format-base lg:format-lg format-blue dark:format-invert w-full md:w-2/3">
            <h1 class="text-2xl font-bold md:text-4xl py-4">
                <?= htmlspecialchars($post['title']); ?>
            </h1>
            <div id="content">
                <?= $post['content']; ?>
            </div>
            <footer class="mt-4 lg:mt-6 not-format">
                <address class="flex items-center mb-6 not-italic">
                    <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                        <!-- <img class="mr-4 w-16 h-16 rounded-full" src="https://dummyimage.com/200" alt="Jese Leos"> -->
                        <div>
                            <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($post['title']); ?></a>
                            <!-- <p class="text-base text-gray-500 dark:text-gray-400">User About</p> -->
                            <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                    title="February 8th, 2022"><?= htmlspecialchars($post['updated_at']); ?></time></p>
                        </div>
                    </div>
                </address>
            </footer>
            <!-- <section class="not-format">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg lg:text-5xl font-bold text-gray-900 dark:text-white">Discussions</h2>
                </div>
                
                <div class="bg-white text-black">
                </div>
            </section> -->
        </article>
        <aside class="px-4 w-full md:w-1/3 sticky right-0">
            <!-- Search -->
            <!-- <div class="mb-6">
                <label for="search" class="sr-only">Search</label>
                <div class="relative">
                    <input type="text" id="search" name="search" placeholder="Search articles..."
                        class="w-full rounded-lg border border-gray-300 pl-4 pr-10 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                    <button class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103 10.5a7.5 7.5 0 0013.65 6.15z" />
                        </svg>
                    </button>
                </div>
            </div> -->
            <!-- Author Info -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white"><?= htmlspecialchars($post['title']); ?></a>
                <div class="flex items-center space-x-4 mt-4">
                    <img class="w-12 h-12 rounded-full" src="<?= url_for("static/user-avatar.png")?>" alt="Author">
                    <div>
                        <h4 class="font-semibold dark:text-gray-300">Author: <span class="font-bold text-gray-100"><?= htmlspecialchars($post['author_name']); ?></span>
                        </h4>
                        <p class="text-sm text-gray-500 dark:text-gray-200"><?= htmlspecialchars($post['updated_at']); ?></p>
                    </div>
                </div>
            </div>
            <!-- Categories -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-100">Categories</h5>
                <ul class="space-y-2">
                    <?php
                    $cat_query = "SELECT * FROM blog_categories ORDER BY name";
                    $cat_result = mysqli_query($conn, $cat_query);
                    while ($category = mysqli_fetch_assoc($cat_result)) { ?>
                        <li>
                            <a href="<?= url_for("category/" . $category["slug"]) ?>"
                                class="text-gray-600 capitalize dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-600">
                                <?= $category["name"] ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- Recent Posts -->
            <?php
            // Fetch All Other Posts
            $otherSql = "
    SELECT
        b.*, u.full_name AS author_name, c.name AS category_name, c.slug AS category_slug
    FROM blog_articles b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN users u ON b.author_id = u.id
    WHERE b.is_published = 1 AND b.category_id = " . $post['category_id'] . "
    ORDER BY b.id DESC;
";
            $otherResult = mysqli_query($conn, $otherSql);

            ?>
            <?php if ($otherResult && $otherResult->num_rows > 0): ?>
                <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                    <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-200">Recent Posts</h5>
                    <ul class="space-y-3">

                        <?php while ($post = $otherResult->fetch_assoc()): ?>

                            <li>
                                <a href="<?= url_for("blog/" . $post['slug']) ?>"
                                    class="flex items-start space-x-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-2">
                                    <img src="<?= get_image_src($post['cover_image_url']) ?>"
                                        class="w-12 h-12 rounded object-cover" alt="">
                                    <div>
                                        <h6 class="text-gray-800 dark:text-gray-200 font-medium leading-snug">
                                            <?= htmlspecialchars($post['title']); ?></h6>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-200"><?= htmlspecialchars($post['updated_at']); ?></span>
                                    </div>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <!-- Tag Cloud -->
            <!-- <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4">
                <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-100">Tags</h5>
                <div class="flex flex-wrap gap-2">
                    <a href="#" class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">Laravel</a>
                </div>
            </div> -->
        </aside>
    </div>
</main>
<?php
// Fetch All Other Posts

$otherSql = "
    SELECT
        b.*, u.full_name AS author_name, c.name AS category_name, c.slug AS category_slug
    FROM blog_articles b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN users u ON b.author_id = u.id
    WHERE b.is_published = 1 AND b.category_id = " . $cid . "
    ORDER BY b.id DESC;
";

$otherResult = mysqli_query($conn, $otherSql);

// If no posts in the category, fallback
if (!$otherResult || $otherResult->num_rows === 0) {
    $otherSql = "
        SELECT
            b.*, u.full_name AS author_name, c.name AS category_name, c.slug AS category_slug
        FROM blog_articles b
        LEFT JOIN blog_categories c ON b.category_id = c.id
        LEFT JOIN users u ON b.author_id = u.id
        WHERE b.is_published = 1
        ORDER BY b.id DESC;
    ";
    $otherResult = mysqli_query($conn, $otherSql);
}
?>

<?php if ($otherResult && $otherResult->num_rows > 0): ?>
    <section aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
        <div class="px-4 mx-auto max-w-screen-xl">
            <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related articles</h2>
            <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                <?php while ($post = $otherResult->fetch_assoc()): ?>
                    <article class="max-w-sm">
                        <a href="<?= url_for("blog/" . $post['slug']) ?>">
                            <img src="<?= get_image_src($post['cover_image_url']) ?>" class="mb-5 rounded-lg" alt="Image 1">
                        </a>
                        <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                            <a href="<?= url_for("blog/" . $post['slug']) ?>"><?= htmlspecialchars($post['title']); ?></a>
                        </h2>
                        <p class="mb-4 text-gray-700 dark:text-white">
                            <?= mb_strimwidth($post['meta_description'], 0, 120, '...'); ?>
                        </p>
                        <a href="#"
                            class="inline-flex items-center font-medium hover:underline hover:underline-offset-4 text-indigo-600 dark:text-indigo-500 ">
                            Read in 2 minutes
                        </a>
                    </article>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php /* ?>
<section class="bg-white dark:bg-gray-900">
<div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
<div class="mx-auto max-w-screen-md sm:text-center">
<h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl dark:text-white">Sign
up for our newsletter</h2>
<p class="mx-auto mb-8 max-w-2xl  text-gray-500 md:mb-12 sm:text-xl dark:text-gray-400">Stay up to date
with the roadmap progress, announcements and exclusive discounts feel free to sign up with your
email.</p>
<form action="#">
<div class="items-center mx-auto mb-3 space-y-4 max-w-screen-sm sm:flex sm:space-y-0">
<div class="relative w-full">
<label for="email"
class="hidden mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email
address</label>
<div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
<svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 16">
<path
d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
<path
d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
</svg>
</div>
<input
class="block p-3 pl-9 w-full text-sm text-gray-900 bg-white dark:bg-gray-900 rounded-lg border border-gray-300 sm:rounded-none sm:rounded-l-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
placeholder="Enter your email" type="email" id="email" required="">
</div>
<div>
<button type="submit"
class="py-3 px-5 w-full text-sm font-medium text-center text-white rounded-lg border cursor-pointer bg-indigo-700 border-indigo-600 sm:rounded-none sm:rounded-r-lg hover:bg-indigo-800 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800">Subscribe</button>
</div>
</div>
<div
class="mx-auto max-w-screen-sm text-sm text-left text-gray-500 newsletter-form-footer dark:text-gray-300">
We care about the protection of your data. <a href="#"
class="font-medium text-indigo-600 dark:text-indigo-500 hover:underline">Read our Privacy
Policy</a>.</div>
</form>
</div>
</div>
</section>
<?php */ ?>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>