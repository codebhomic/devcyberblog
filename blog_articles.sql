-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2025 at 01:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `devcyberblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog_articles`
--

CREATE TABLE `blog_articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `author_id` int(11) NOT NULL,
  `category_id` int(255) NOT NULL,
  `content` text NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `cover_image_url` text DEFAULT NULL,
  `is_deleted` int(10) DEFAULT NULL,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_published` tinyint(1) DEFAULT 0,
  `is_featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_articles`
--

INSERT INTO `blog_articles` (`id`, `title`, `slug`, `author_id`, `category_id`, `content`, `meta_title`, `meta_description`, `meta_keywords`, `cover_image_url`, `is_deleted`, `published_at`, `is_published`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 'What is a Website? How Websites Work and How to Create One Easily', 'what-is-a-website-how-websites-work-and-how-to-create-one-easily-37002', 2, 1, '<div>\r\n\r\n\r\n<h3>What is a Website?</h3>\r\n<p>A <strong>website</strong> is a collection of related web pages that are stored on a special computer called a <strong>web server</strong>. These web pages can include text, images, videos, forms, and interactive features. You can access a website using any device with a web browser (like Chrome, Firefox, or Safari) and an internet connection.</p>\r\n<p>Each website has a unique address called a <strong>domain name</strong> (for example, <code>www.example.com</code>). When you enter this address into your browser, the browser requests the website’s content from the server, and the server sends back the necessary files to display the web pages on your screen.</p>\r\n<hr />\r\n<h3>How Does a Website Run?</h3>\r\n<p>Here’s a simplified overview of how a website works behind the scenes:</p>\r\n<ol>\r\n<li>\r\n<p><strong>Domain Name Resolution</strong></p>\r\n<ul>\r\n<li>\r\n<p>You type the website address into your browser.</p>\r\n</li>\r\n<li>\r\n<p>The domain name is translated into an IP address by the DNS (Domain Name System).</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Request to the Server</strong></p>\r\n<ul>\r\n<li>\r\n<p>Your browser sends a request over the internet to the web server that hosts the website.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Server Response</strong></p>\r\n<ul>\r\n<li>\r\n<p>The server processes the request and sends back the website files (HTML, CSS, JavaScript, images).</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Rendering</strong></p>\r\n<ul>\r\n<li>\r\n<p>Your browser reads these files and displays the web pages in a format you can see and interact with.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n<li>\r\n<p><strong>Interactivity</strong></p>\r\n<ul>\r\n<li>\r\n<p>JavaScript and other scripts allow the website to respond to your clicks, form submissions, and other actions.</p>\r\n</li>\r\n</ul>\r\n</li>\r\n</ol>\r\n<hr />\r\n<h3>How to Create a Website</h3>\r\n<p>Creating a website involves several steps. Here’s a simple guide to get you started:</p>\r\n<p>✅ <strong>1. Choose a Purpose</strong><br />\r\nDecide what your website will be about—a blog, portfolio, business site, or online store.</p>\r\n<p>✅ <strong>2. Register a Domain Name</strong><br />\r\nPurchase a unique domain name that represents your brand or idea.</p>\r\n<p>✅ <strong>3. Get Web Hosting</strong><br />\r\nSign up with a hosting provider to store your website files and make them accessible online.</p>\r\n<p>✅ <strong>4. Design Your Website</strong><br />\r\nYou can:</p>\r\n<ul>\r\n<li>\r\n<p>Use a website builder (like Wix, Squarespace, or WordPress) for ease of use.</p>\r\n</li>\r\n<li>\r\n<p>Code manually with HTML, CSS, and JavaScript for more control and customization.</p>\r\n</li>\r\n</ul>\r\n<p>✅ <strong>5. Create Web Pages</strong><br />\r\nDevelop the core pages (Home, About, Contact, etc.). Use:</p>\r\n<ul>\r\n<li>\r\n<p><strong>HTML</strong> to structure the content.</p>\r\n</li>\r\n<li>\r\n<p><strong>CSS</strong> to style the appearance.</p>\r\n</li>\r\n<li>\r\n<p><strong>JavaScript</strong> to add interactivity.</p>\r\n</li>\r\n</ul>\r\n<p>✅ <strong>6. Test and Launch</strong><br />\r\nPreview your website on different devices and browsers to ensure it works correctly. Once ready, publish it live.</p>\r\n<p>✅ <strong>7. Maintain and Update</strong><br />\r\nRegularly update your website with fresh content, security patches, and improvements.</p>\r\n<hr />\r\n<h3>Final Thoughts</h3>\r\n<p>Websites are the backbone of the internet, enabling people and businesses to share information, offer services, and connect globally. With modern tools and resources, creating a website has become more accessible than ever—even if you’re just getting started.</p></div>', 'What is a Website? How It Works & Steps to Build One', 'Learn what a website is, how it works behind the scenes, and how you can create your own website step by step using modern web technologies.', NULL, '/static/website_development.jpg', 0, '2025-07-15 15:15:12', 1, 1, '2025-07-03 12:59:02', '2025-07-03 12:59:02');

-- --------------------------------------------------------

--
-- Table structure for table `blog_article_tags`
--

CREATE TABLE `blog_article_tags` (
  `article_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `name`, `slug`, `image`, `description`, `created_at`, `updated_at`) VALUES
(1, 'web development', 'web-development', 'http://localhost/dev_cyber_blog/static/website_development.jpg', '<p><strong>Web Development</strong>, also known as <strong>Website Development</strong>, is the process of creating websites and web applications that you can access over the internet.</p>\r\n\r\n\r\n<p>But wait—<strong>what is a website?</strong></p>\r\n\r\n\r\n<p>A <strong>website</strong> is a collection of interlinked <strong>web pages</strong> that are stored on a computer called a <strong>server</strong>. You can visit a website using your web browser, which communicates with the server through special internet protocols such as <strong>HTTP</strong> or <strong>HTTPS</strong>.</p>\r\n\r\n\r\n<p>These web pages aren’t just plain text. They are built using a combination of languages and technologies:</p>\r\n\r\n\r\n<ul>\r\n<li>\r\n<p><strong>HTML (Hypertext Markup Language)</strong> provides the basic structure and content of a page.</p>\r\n</li>\r\n<li>\r\n<p><strong>CSS (Cascading Style Sheets)</strong> controls how the page looks—its layout, colors, and fonts.</p>\r\n</li>\r\n<li>\r\n<p><strong>JavaScript</strong> adds interactivity, allowing web pages to respond dynamically to user actions.</p>\r\n</li>\r\n</ul>\r\n\r\n\r\n<p>Together, these technologies enable developers to create everything from simple static websites to complex, dynamic web applications that power today’s digital world.</p>', '2025-07-03 21:49:08', '2025-07-03 23:08:05'),
(2, 'category', 'category-name', 'https://dummyimage.com/200', '<p>category</p>', '2025-07-08 00:47:42', '2025-07-08 00:55:08');

-- --------------------------------------------------------

--
-- Table structure for table `blog_tags`
--

CREATE TABLE `blog_tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int(10) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `demo_user`
--

CREATE TABLE `demo_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('coPG4v3dxwL5j6UkGtbReGnTY39xwO5TfjLi18mQ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDBHdU03Y1NkTWZLakdRQ2lNU09TMTh0bHl5WXVnMFh2Tnd4YXFVVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1751054226);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user_type` enum('user','admin','author') DEFAULT 'user',
  `google_id` varchar(255) DEFAULT NULL,
  `google_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `full_name`, `phone`, `user_type`, `google_id`, `google_picture`, `created_at`) VALUES
(2, 'bhoumicgarg', 'businessbhoumic@gmail.com', '$2y$12$YlUD/zCKPJJ6vWYVeVPec.2cz3iPw.OQ3eCEirh3I59U0OsvreyHm', 'Bhoumic Garg', '', 'admin', NULL, NULL, '2025-07-03 14:01:23'),
(4, 'kastab', 'kastab@gmail.com', '$2y$12$SkmWc210lA8V8gi8MkfvqekYQtFljYm7.aFJFeUZH8x85p9awuHfi', 'Kastab Garai', '', 'admin', NULL, NULL, '2025-07-15 07:38:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `blog_article_tags`
--
ALTER TABLE `blog_article_tags`
  ADD PRIMARY KEY (`article_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `blog_tags`
--
ALTER TABLE `blog_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `demo_user`
--
ALTER TABLE `demo_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD UNIQUE KEY `google_id_unique` (`google_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog_articles`
--
ALTER TABLE `blog_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `blog_tags`
--
ALTER TABLE `blog_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `demo_user`
--
ALTER TABLE `demo_user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blog_articles`
--
ALTER TABLE `blog_articles`
  ADD CONSTRAINT `blog_articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `blog_article_tags`
--
ALTER TABLE `blog_article_tags`
  ADD CONSTRAINT `blog_article_tags_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `blog_articles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `blog_article_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `blog_tags` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
