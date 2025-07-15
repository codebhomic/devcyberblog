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

function process_image_url($input_url) {
    $parsed = parse_url($input_url);
    print_r1($parsed);
    // If no host, it's already relative
    if (!isset($parsed['host'])) {
        return $input_url;
    }

    // If the host matches your own domain, store relative
    if ($parsed['host'] === SITE_URL) {
        return $parsed['path'];
    }

    // Otherwise, keep full URL (external)
    return $input_url;
}

function get_image_src($image_url) {
    if (strpos($image_url, 'http') === 0) {
        // External URL
        return $image_url;
    }
    // Local file
    return  htmlspecialchars(SITE_URL . $image_url);
}
