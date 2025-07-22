<?php
require_once "includes/helper.php";
$uploadsDir = __DIR__ . '/admin/uploads/';
$file = isset($_GET['file']) ? basename($_GET['file']) : '';

if ($file && preg_match('/^[\w\-.]+\.(jpg|jpeg|png|gif|pdf|docx|txt)$/i', $file)) {
    $filePath = $uploadsDir . $file;

    if (file_exists($filePath)) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // fallback MIME
        if (!$mimeType || $mimeType === 'application/octet-stream') {
            $ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $mimeMap = [
                'jpg' => 'image/jpeg', 'jpeg'=> 'image/jpeg', 'png' => 'image/png',
                'gif' => 'image/gif', 'pdf' => 'application/pdf',
                'docx'=> 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'txt' => 'text/plain'
            ];
            $mimeType = $mimeMap[$ext] ?? 'application/octet-stream';
        }

        header('Content-Type: ' . $mimeType);
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . $file . '"');
        readfile($filePath);
        exit;
    }
}
error_page(404);