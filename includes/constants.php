<?php
// General
define('SITE_NAME', 'Bug2Build');
define('SITE_DOMAIN', 'bug2build.in');
define('SITE_URL', 'http://localhost/dev_cyber_blog/');
// define('SITE_URL', 'http://localhost/dev_cyber_blog/');
define('SITE_EMAIL', 'support@bug2build.in');
define('DEFAULT_LANGUAGE', 'en');
define('SITE_DESCREPTION', 'Get updates and blogs regarding cyber and devlopment related queries.');

define('DBHOST', '');
define('DBUSERNAME', '');
define('DBPASSWORD', '');
define('DBNAME', '');

// Paths
define('UPLOAD_PATH', __DIR__ . '/../uploads/');
define('UPLOAD_URL', SITE_URL . '/uploads/');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);

// Security
define('PASSWORD_HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_TIMEOUT', 3600);
define('ENABLE_CSRF_PROTECTION', true);
define('ADMIN_LOGIN_ATTEMPTS', 5);

// Emails
define('MAIL_FROM_ADDRESS', 'no-reply@example.com');
define('MAIL_FROM_NAME', 'My Blog');
define('SMTP_HOST', 'smtp.example.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'smtp_user');
define('SMTP_PASSWORD', 'secret_password');

// Blog/SEO
define('DEFAULT_META_DESCRIPTION', 'Get updates and blogs regarding cyber and devlopment related queries.');
define('ARTICLES_PER_PAGE', 10);
define('ENABLE_COMMENTS', true);
define('ENABLE_TAGS', true);
define('ENABLE_CATEGORIES', true);

// Analytics
define('GOOGLE_ANALYTICS_ID', '');
define('FACEBOOK_PIXEL_ID', '');
