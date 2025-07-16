<?php
session_start();
require_once 'includes/helper.php';
require_once 'includes/db_connect.php';
// Set page title
$page_title = "About Us";

ob_start();
?>
<section class="py-12 bg-white dark:bg-gray-900">
  <div class="max-w-4xl mx-auto px-4 text-center">
    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
      About Us
    </h2>
    <p class="text-gray-600 dark:text-gray-300 mb-8">
      Welcome to our blog! We are a team of three friends dedicated to sharing knowledge, ideas, and inspiration. Each of us brings a unique perspective and voice to our articles.
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
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
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
          I am BTech CSE student, passionate about coding, my expertise is in website developement in php and python. I here guide you in your journey just as learner.
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
          Kastab Garai is Btech Cyber Security Student, expertise in cyber security, linux administration, decent programming experince, with a very good understanding of c language.
        </p>
      </div>
      <!-- Author 3 -->
      <!-- <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 shadow hover:shadow-lg transition">
        <img
          src="https://via.placeholder.com/120"
          alt="Author 3"
          class="w-24 h-24 mx-auto rounded-full mb-4"
        /> 
        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
          Author 3
        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">
          Sharing stories and personal experiences.
        </p>
      </div> -->
    </div>
  </div>
</section>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>