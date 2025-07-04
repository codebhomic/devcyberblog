<?php
require_once "constants.php";
function url_for($url){
    echo SITE_URL . $url;
}

function print_rdie($arr){
    echo "<pre>";
    print_r($arr);
    die();
}
function print_r1($arr){
    echo "<pre>";
    print_r($arr);
}

function get_logged_in_user($conn) {
    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    $user_id = intval($_SESSION['user_id']); // Sanitization
    $sql = "SELECT id, email, user_type, full_name, created_at FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        return null;
    }
    
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    // print_r1([$stmt,$user_id,$result]);

    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row; // associative array of user details
    }

    return null; // user not found
}

function error_page($error): void{
    $page = "error/" . $error . ".php";
    if (file_exists($page)) {
        include $page;
    } else if (file_exists("../" . $page)) {
        include "../" . $page;
    } else if (file_exists("../../" . $page)) {
        include "../" . $page;
    } else {
        die("500 | Server Error | File Not Found Which is Being Requested");
    }
}