<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

$host = "localhost";
$dbUsername = "ndnblgxq_bg";
$dbPassword = "Khushi@123";
$dbName = "ndnblgxq_blogbykb";

// Database Configuration for coupons.php
define('DB_HOST', $host);
define('DB_USER', $dbUsername);  // Default XAMPP MySQL username
define('DB_PASS', $dbPassword);      // Default XAMPP MySQL password is empty
define('DB_NAME', $dbName);  // Updated database name

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// PDO Connection for prepared statements
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?> 