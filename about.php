<?php
session_start();
require_once 'includes/helper.php';
require_once 'includes/db_connect.php';
// Set page title
$page_title = "About Us";

ob_start();
?>
<section class="py-12 bg-white dark:bg-gray-900">
  <div class="max-w-6xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
      About Us
    </h2>
    <p class="text-gray-600 dark:text-gray-300 mb-6">
      We are a team of passionate tech enthusiasts, currently pursuing BTech in Computer Science and Cyber Security.
      United by our love for learning and sharing knowledge, we've created this blog to document our journey, projects,
      and insights in tech.
      Our goal is to inspire and help others in their learning paths, just as we continue to grow every day.
    </p>
    <div class="grid sm:grid-cols-3 gap-6 max-w-6xl mx-auto">
      <!-- Author 1 -->
      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
        <!-- <img
          src="https://via.placeholder.com/120"
          alt="Author 1"
          class="w-24 h-24 mx-auto rounded-full mb-4"
        /> -->
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
          Bhoumic Garg
        </h3>
        <p class="text-smd text-gray-600 dark:text-gray-300 mt-2">
          A B.Tech Computer Science student passionate about coding and building from scratch. With hands-on experience in web development using PHP and Python, Bhoumic focuses on crafting practical, scalable solutions and loves sharing the process with fellow learners.
        </p>
      </div>
      <!-- Author 2 -->
      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
        <!-- <img
          src="https://via.placeholder.com/120"
          alt="Author 2"
          class="w-24 h-24 mx-auto rounded-full mb-4"
        /> -->
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
          Kastab Garai
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
         Currently pursuing B.Tech in Cyber Security, Kastab brings expertise in cybersecurity, Linux administration, and a deep understanding of C programming. He’s passionate about low-level systems, ethical hacking, and keeping the digital world secure.
        </p>
      </div>
      <!-- Author 3 -->
      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
        <!-- <img
          src="https://via.placeholder.com/120"
          alt="Author 3"
          class="w-24 h-24 mx-auto rounded-full mb-4"
        />  -->
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
          Vanshika Tyagi
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
          I am Vanshika, a B.Tech Computer Science student with a specialization in Artificial Intelligence. I am
          passionate about technology, content creation, and building innovative projects that create impact.
        </p>
      </div>
    </div>
  </div>
</section>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>