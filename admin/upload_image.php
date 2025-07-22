<?php
require_once "../includes/db_connect.php";
require_once "../includes/helper.php";

header("Content-Type: application/json");

$uploadDir = __DIR__ . "/uploads/";
$webPath = "uploads/";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

    if (!in_array($ext, $allowed)) {
        echo json_encode(["success" => false, "error" => "Invalid file type"]);
        exit;
    }

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $newName = uniqid("img_", true) . "." . $ext;
    $filePath = $uploadDir . $newName;

    if (move_uploaded_file($file["tmp_name"], $filePath)) {
        echo json_encode([
            "success" => true,
            "url" => SITE_URL.$webPath . $newName
        ]);
    } else {
        echo json_encode(["success" => false, "error" => "Upload failed"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded"]);
}
