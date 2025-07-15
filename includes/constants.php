<?php
// General
define('SITE_NAME', 'Dev Cyber Blog');
define('SITE_DOMAIN', 'blogbykb.istecgcmohali.in');
define('SITE_URL', 'https://blogbykb.istecgcmohali.in/');
define('SITE_EMAIL', 'admin@example.com');
define('DEFAULT_LANGUAGE', 'en');
define('TIMEZONE', 'UTC');

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
define('DEFAULT_META_DESCRIPTION', 'This is my blog about amazing topics.');
define('ARTICLES_PER_PAGE', 10);
define('ENABLE_COMMENTS', true);
define('ENABLE_TAGS', true);
define('ENABLE_CATEGORIES', true);

// Analytics
define('GOOGLE_ANALYTICS_ID', '');
define('FACEBOOK_PIXEL_ID', '');
