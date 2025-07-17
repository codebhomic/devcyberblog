<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
require_once "constants.php";
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "devcyberblog";

$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?> 