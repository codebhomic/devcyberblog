<?php
session_start();
require_once 'includes/helper.php';
require_once 'includes/db_connect.php';
// Set page title
$page_title = "About Us";

ob_start();
?>
<section class="bg-white dark:bg-gray-900 py-12 px-4">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
    

    <!-- Official Contact Info -->
    <div class="w-full space-y-6">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Get in Touch</h2>
      <p class="text-gray-600 dark:text-gray-300">
        We'd love to hear from you! Fill out the form or reach us directly using the information below.
      </p>

      <div class="space-y-4">
        <div class="flex items-start gap-3">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 4.5L21.75 19.5M21.75 4.5L2.25 19.5" />
          </svg>
          <div>
            <p class="text-gray-800 dark:text-white font-medium">Email</p>
            <p class="text-gray-600 dark:text-gray-300"><?= SITE_EMAIL?></p>
          </div>
        </div>
<!-- 
        <div class="flex items-start gap-3">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 4.5l19.5 0M2.25 12l19.5 0M2.25 19.5l19.5 0" />
          </svg>
          <div>
            <p class="text-gray-800 dark:text-white font-medium">Phone</p>
            <p class="text-gray-600 dark:text-gray-300">+91 98765 43210</p>
          </div>
        </div> -->

        <!-- <div class="flex items-start gap-3">
          <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 12.414A4 4 0 1116 9.828l4.243 4.243a6 6 0 01-2.586 2.586z" />
          </svg>
          <div>
            <p class="text-gray-800 dark:text-white font-medium">Address</p>
            <p class="text-gray-600 dark:text-gray-300">123 Dev Street, Cyber City, India</p>
          </div>
        </div> -->
      </div>

    </div>
    <!-- Google Form Iframe -->
    <div class="w-full">
      <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Contact Form</h2>
      <iframe 
        src="https://docs.google.com/forms/d/e/1FAIpQLSf7otyTkDbWu88eDvydmfZxFULWMsbUiqHwkrgdmfOYLBngiA/viewform?embedded=true" 
        width="100%" 
        height="1120" 
        frameborder="0" 
        marginheight="0" 
        marginwidth="0"
        class="w-full rounded-lg border dark:border-gray-700">
        Loading…
      </iframe>
    </div>
  </div>
</section>

<?php
// Get the buffered content
$content = ob_get_clean();

// Include the layout
include 'includes/base_layout.php';
?>