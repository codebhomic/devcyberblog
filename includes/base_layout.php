<?php

// Set the active page
$current_page = basename($_SERVER['PHP_SELF']);

?>
<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-site-verification" content="f56RNLwvR1rnp5bwPO1rH-lCYvkSqXnOkB6Yo41OIUo" />
    <title><?= $page_title; ?> - <?= SITE_NAME ?></title>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= url_for('static/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= url_for('static/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= url_for('static/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= url_for('static/site.webmanifest') ?>">
    <script src="<?= url_for("static/js/tailwind.config.js"); ?>"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
</head>
<?php
/*
                if (!is_login()):
                    ?>
                    <a href="<?= url_for("login.php") ?>"
                        class="text-gray-800 border-2 border-indigo-500 dark:text-white hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        Log in</a>
                <?php else: ?>
                    <a href="<?= url_for("admin/dashboard.php") ?>"
                        class="text-gray-800 border-2 border-indigo-500 dark:text-white hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-300 font-medium rounded-lg text-sm px-4 lg:px-5 py-2 lg:py-2.5 mr-2 dark:hover:bg-indigo-700 focus:outline-none dark:focus:ring-indigo-800">
                        dashboard</a>
                <?php endif; */
?>

<body>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v23.0"></script>
    <header>
  <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
      <!-- Logo -->
      <a href="<?= url_for('index.php'); ?>" class="flex items-center">
        <span class="self-center text-xl font-semibold whitespace-nowrap text-black dark:text-white"><?= SITE_NAME ?></span>
      </a>

      <!-- Mobile menu button (hamburger) -->
      <button data-collapse-toggle="mobile-menu-2" type="button"
        class="inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700"
        aria-controls="mobile-menu-2" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd"
            d="M3 5h14a1 1 0 00 0-2H3a1 1 0 000 2zm14 4H3a1 1 0 000 2h14a1 1 0 000-2zm0 6H3a1 1 0 000 2h14a1 1 0 000-2z"
            clip-rule="evenodd" />
        </svg>
      </button>

      <!-- Navigation links -->
      <div class="hidden w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
        <ul class="flex flex-col font-medium mt-4 border border-gray-100 rounded-lg bg-gray-50 lg:flex-row lg:space-x-8 lg:mt-0 lg:border-0 lg:bg-white dark:bg-gray-800 lg:dark:bg-gray-800 dark:border-gray-700">
          <li>
            <a href="<?= url_for('index.php'); ?>"
              class="block py-2 pl-3 pr-4 text-white bg-blue-700 rounded lg:bg-transparent lg:text-blue-700 lg:p-0 dark:text-white"
              aria-current="page">Home</a>
          </li>
          <li>
            <a href="<?= url_for('about.php') ?>"
              class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">About Us</a>
          </li>

          <!-- Dropdown for Categories -->
          <li>
            <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar"
              class="flex items-center justify-between w-full py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 lg:w-auto dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">
              Categories
              <svg class="w-2.5 h-2.5 ml-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>

            <!-- Dropdown menu -->
            <div id="dropdownNavbar"
              class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
              <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                <?php
                $cat_query = "SELECT * FROM blog_categories ORDER BY name";
                $cat_result = mysqli_query($conn, $cat_query);
                while ($category = mysqli_fetch_assoc($cat_result)) { ?>
                  <li>
                    <a href="<?= url_for("category/" . $category["slug"]) ?>"
                      class="block px-4 py-2 capitalize hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                      <?= $category["name"] ?>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
          </li>

          <li>
            <a href="<?= url_for('contact.php') ?>"
              class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 lg:hover:bg-transparent lg:border-0 lg:hover:text-blue-700 lg:p-0 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent">Contact
              Us</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

    <?php if (isset($_SESSION['success'])) { ?>
        <div id="alert-2"
            class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
            role="alert">
            <svg class="shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <span class="sr-only">Info</span>
            <div class="ms-3 text-sm font-medium">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
            <button type="button"
                class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
                data-dismiss-target="#alert-2" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        </div>
    <?php } ?>

    <!-- Main content -->
    <?php echo $content; ?>

    <footer class="text-gray-600 dark:text-gray-200 dark:bg-gray-900 body-font">
        <div
            class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 flex md:items-center lg:items-start md:flex-row md:flex-nowrap flex-wrap flex-col">
            <div class="w-64 flex-shrink-0 md:mx-0 mx-auto text-center md:text-left">
                <a
                    class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900 dark:text-gray-100">
                    <span class="text-xl"><?= SITE_NAME ?></span>
                </a>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-100"><?= SITE_DESCREPTION ?></p>
            </div>
            <div class="flex-grow flex flex-wrap md:pl-20 -mb-10 md:mt-0 mt-10 md:text-left text-center">
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 dark:text-gray-100 tracking-widest text-sm mb-3">
                        Categories</h2>
                    <nav class="list-none mb-10">
                        <?php
                        $cat_query = "SELECT * FROM blog_categories ORDER BY name";
                        $cat_result = mysqli_query($conn, $cat_query);
                        while ($category = mysqli_fetch_assoc($cat_result)) { ?>
                            <li>
                                <a href="<?= url_for("category/" . $category["slug"]) ?>"
                                    class="text-gray-600 capitalize dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400">
                                    <?= $category["name"] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </nav>
                </div>
                <div class="lg:w-1/4 md:w-1/2 w-full px-4">
                    <h2 class="title-font font-medium text-gray-900 dark:text-gray-100 tracking-widest text-sm mb-3">
                        Pages</h2>
                    <nav class="list-none mb-10">
                        <li>
                            <a href="<?= url_for("") ?>"
                                class="text-gray-600 capitalize dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400">Home</a>
                        </li>
                        <li>
                            <a href="<?= url_for("about.php") ?>"
                                class="text-gray-600 capitalize dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400">About
                                Us</a>
                        </li>
                        <li>
                            <a href="<?= url_for("contact.php") ?>"
                                class="text-gray-600 capitalize dark:text-gray-200 hover:text-gray-800 dark:hover:text-gray-400">Contact
                                Us</a>
                        </li>
                    </nav>
                </div>
                <div class="lg:w-2/4 w-full px-4 text-left ">
                    <h2 class="title-font font-medium text-gray-900 dark:text-gray-100 tracking-widest text-sm mb-3">
                        Recents Posts</h2>
                    <?php
                    // Fetch All Other Posts
                    $otherSql = "
    SELECT
        b.*, u.full_name AS author_name, c.name AS category_name, c.slug AS category_slug
    FROM blog_articles b
    LEFT JOIN blog_categories c ON b.category_id = c.id
    LEFT JOIN users u ON b.author_id = u.id
    WHERE b.is_published = 1 AND b.is_deleted != 1
    ORDER BY b.id DESC;
";
                    $otherResult = mysqli_query($conn, $otherSql);

                    ?>
                    <?php if ($otherResult && $otherResult->num_rows > 0): ?>
                        <nav class="list-none mb-10">


                            <?php while ($post = $otherResult->fetch_assoc()): ?>

                                <li>
                                    <a href="<?= url_for("blog/" . $post['slug']) ?>"
                                        class="flex items-start space-x-3 hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-2">
                                        <img src="<?= get_image_src($post['cover_image_url']) ?>"
                                            class="w-12 h-12 rounded object-cover" alt="">
                                        <div>
                                            <h6 class="text-gray-800 dark:text-gray-200 font-medium leading-snug">
                                                <?= htmlspecialchars($post['title']); ?>
                                            </h6>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-200"><?= htmlspecialchars($post['updated_at']); ?></span>
                                        </div>
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </nav>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="bg-gray-100 dark:bg-gray-900">
            <div class="container mx-auto py-4 px-5 flex flex-wrap items-center justify-center flex-col sm:flex-row">
                <p class="text-gray-500 dark:text-gray-100 text-md text-center">© <?= date('Y') ?> <?= SITE_NAME ?> All Rights Reserved</p>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script src="<?= url_for("static/js/scipt.js"); ?>"></script>
</body>

</html>
