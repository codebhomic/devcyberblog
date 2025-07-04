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

// print_r($post);
// die();
if (!$post) {
    // Set page title
    header("HTTP/1.1 404 Not Found");
    include "error/404.html";
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
                <?php echo htmlspecialchars($post['title']); ?>
            </h1>
            <div id="content">
                <?php echo $post['content']; ?>
            </div>
            <footer class="mt-4 lg:mt-6 not-format">
                <address class="flex items-center mb-6 not-italic">
                    <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                        <!-- <img class="mr-4 w-16 h-16 rounded-full" src="https://dummyimage.com/200" alt="Jese Leos"> -->
                        <div>
                            <a href="#" rel="author" class="text-xl font-bold text-gray-900 dark:text-white">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                            <p class="text-base text-gray-500 dark:text-gray-400">Graphic Designer, educator & CEO
                                Flowbite</p>
                            <p class="text-base text-gray-500 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                    title="February 8th, 2022">Feb. 8, 2022</time></p>
                        </div>
                    </div>
                </address>
                <h1
                    class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white">
                    Best practices for successful prototypes</h1>
            </footer>
            <section class="not-format">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Discussion (20)</h2>
                </div>
                <form class="mb-6">
                    <div
                        class="py-2 px-4 mb-4 bg-white dark:bg-gray-900 rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                        <label for="comment" class="sr-only">Your comment</label>
                        <textarea id="comment" rows="6"
                            class="px-3 py-1 w-full text-sm text-gray-900 border-0 focus:ring-0 dark:text-white dark:placeholder-gray-400 dark:bg-gray-800"
                            placeholder="Write a comment..." required></textarea>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-indigo-700 rounded-lg focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-900 hover:bg-indigo-800">
                        Post comment
                    </button>
                </form>
                <article class="p-6 text-base bg-white dark:bg-gray-900 rounded-lg dark:bg-gray-900">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p
                                class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white">
                                <img class="mr-2 w-6 h-6 rounded-full" src="https://dummyimage.com/200"
                                    alt="Michael Gough">Michael Gough
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-08"
                                    title="February 8th, 2022">Feb. 8, 2022</time></p>
                        </div>
                        <button id="dropdownComment1Button" data-dropdown-toggle="dropdownComment1"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white dark:bg-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 16 3">
                                <path
                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                            <span class="sr-only">Comment settings</span>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownComment1"
                            class="hidden z-10 w-36 bg-white dark:bg-gray-900 rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                </li>
                            </ul>
                        </div>
                    </footer>
                    <p>Very straight-to-point article. Really worth time reading. Thank you! But tools are just the
                        instruments for the UX designers. The knowledge of the design tools are as important as the
                        creation of the design strategy.</p>
                    <div class="flex items-center mt-4 space-x-4">
                        <button type="button"
                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 18">
                                <path
                                    d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z" />
                            </svg>
                            Reply
                        </button>
                    </div>
                </article>
                <article class="p-6 ml-6 lg:ml-12 text-base bg-white dark:bg-gray-900 rounded-lg dark:bg-gray-900">
                    <footer class="flex justify-between items-center mb-2">
                        <div class="flex items-center">
                            <p
                                class="inline-flex items-center mr-3 font-semibold text-sm text-gray-900 dark:text-white">
                                <img class="mr-2 w-6 h-6 rounded-full" src="https://dummyimage.com/200"
                                    alt="Jese Leos">Jese Leos
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="2022-02-12"
                                    title="February 12th, 2022">Feb. 12, 2022</time></p>
                        </div>
                        <button id="dropdownComment2Button" data-dropdown-toggle="dropdownComment2"
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white dark:bg-gray-900 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50 dark:text-gray-400 dark:bg-gray-900 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                            type="button">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 16 3">
                                <path
                                    d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z" />
                            </svg>
                            <span class="sr-only">Comment settings</span>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownComment2"
                            class="hidden z-10 w-36 bg-white dark:bg-gray-900 rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownMenuIconHorizontalButton">
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Remove</a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Report</a>
                                </li>
                            </ul>
                        </div>
                    </footer>
                    <p>Much appreciated! Glad you liked it ☺️</p>
                    <div class="flex items-center space-x-4">
                        <button type="button"
                            class="flex items-center font-medium text-sm text-gray-500 hover:underline dark:text-gray-400">
                            <svg class="mr-1.5 w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 18">
                                <path
                                    d="M18 0H2a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h2v4a1 1 0 0 0 1.707.707L10.414 13H18a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2Zm-5 4h2a1 1 0 1 1 0 2h-2a1 1 0 1 1 0-2ZM5 4h5a1 1 0 1 1 0 2H5a1 1 0 0 1 0-2Zm2 5H5a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Zm9 0h-6a1 1 0 0 1 0-2h6a1 1 0 1 1 0 2Z" />
                            </svg>
                            Reply
                        </button>
                    </div>
                </article>
            </section>
        </article>
        <aside class="px-4 w-full md:w-1/3 sticky right-0">
            <!-- Search -->
            <div class="mb-6">
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
            </div>
            <!-- Author Info -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                <div class="flex items-center space-x-4">
                    <img class="w-12 h-12 rounded-full" src="https://dummyimage.com/200" alt="Author">
                    <div>
                        <h4 class="font-semibold dark:text-gray-100">John Doe</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-200">Editor-in-Chief</p>
                    </div>
                </div>
                <p class="mt-2 text-gray-600 dark:text-gray-200 text-sm">
                    Passionate about writing clean code and clean prose.
                </p>
            </div>
            <!-- Categories -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-200">Categories</h5>
                <ul class="space-y-2">
                    <li><a href="#" class="text-blue-600 hover:underline">Technology</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Tutorials</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Business</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Design</a></li>
                </ul>
            </div>
            <!-- Recent Posts -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4 mb-6">
                <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-200">Recent Posts</h5>
                <ul class="space-y-3">
                    <li>
                        <a href="#"
                            class="flex items-start space-x-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-2">
                            <img src="https://dummyimage.com/200" class="w-12 h-12 rounded object-cover" alt="">
                            <div>
                                <h6 class="text-gray-800 dark:text-gray-200 font-medium leading-snug">How to Build a
                                    Blog in Laravel
                                </h6>
                                <span class="text-xs text-gray-500 dark:text-gray-200">June 10, 2025</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-start space-x-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-2">
                            <img src="https://dummyimage.com/200" class="w-12 h-12 rounded object-cover" alt="">
                            <div>
                                <h6 class="text-gray-800 dark:text-gray-200 font-medium leading-snug">10 Tailwind Tips
                                    for Beginners
                                </h6>
                                <span class="text-xs text-gray-500 dark:text-gray-200">June 5, 2025</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Tag Cloud -->
            <div class="bg-white dark:bg-gray-900 border border-gray-200 rounded-lg p-4">
                <h5 class="font-semibold mb-3 text-gray-800 dark:text-gray-100">Tags</h5>
                <div class="flex flex-wrap gap-2">
                    <a href="#"
                        class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">Laravel</a>
                    <a href="#"
                        class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">PHP</a>
                    <a href="#"
                        class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">Tailwind</a>
                    <a href="#"
                        class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">Tips</a>
                    <a href="#"
                        class="text-gray-800 dark:text-gray-300 bg-gray-100 hover:bg-gray-200 dark:bg-gray-500 dark:hover:bg-gray-700 text-sm px-3 py-1 rounded">JavaScript</a>
                </div>
            </div>
        </aside>
    </div>
</main>

<section aria-label="Related articles" class="py-8 lg:py-24 bg-gray-50 dark:bg-gray-800">
    <div class="px-4 mx-auto max-w-screen-xl">
        <h2 class="mb-8 text-2xl font-bold text-gray-900 dark:text-white">Related articles</h2>
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-4">
            <article class="max-w-xs">
                <a href="#">
                    <img src="https://dummyimage.com/200" class="mb-5 rounded-lg" alt="Image 1">
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="#">Our first office</a>
                </h2>
                <p class="mb-4 text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                    changes! After months of preparation.</p>
                <a href="#"
                    class="inline-flex items-center font-medium hover:underline hover:underline-offset-4 text-indigo-600 dark:text-indigo-500 ">
                    Read in 2 minutes
                </a>
            </article>
            <article class="max-w-xs">
                <a href="#">
                    <img src="https://dummyimage.com/200" class="mb-5 rounded-lg" alt="Image 2">
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="#">Enterprise design tips</a>
                </h2>
                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                    changes! After months of preparation.</p>
                <a href="#"
                    class="inline-flex items-center font-medium hover:underline hover:underline-offset-4 text-indigo-600 dark:text-indigo-500 ">
                    Read in 12 minutes
                </a>
            </article>
            <article class="max-w-xs">
                <a href="#">
                    <img src="https://dummyimage.com/200" class="mb-5 rounded-lg" alt="Image 3">
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="#">We partnered with Google</a>
                </h2>
                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                    changes! After months of preparation.</p>
                <a href="#"
                    class="inline-flex items-center font-medium hover:underline hover:underline-offset-4 text-indigo-600 dark:text-indigo-500 ">
                    Read in 8 minutes
                </a>
            </article>
            <article class="max-w-xs">
                <a href="#">
                    <img src="https://dummyimage.com/200" class="mb-5 rounded-lg" alt="Image 4">
                </a>
                <h2 class="mb-2 text-xl font-bold leading-tight text-gray-900 dark:text-white">
                    <a href="#">Our first project with React</a>
                </h2>
                <p class="mb-4  text-gray-500 dark:text-gray-400">Over the past year, Volosoft has undergone many
                    changes! After months of preparation.</p>
                <a href="#"
                    class="inline-flex items-center font-medium hover:underline hover:underline-offset-4 text-indigo-600 dark:text-indigo-500 ">
                    Read in 4 minutes
                </a>
            </article>
        </div>
    </div>
</section>

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
<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>