<?php
require_once("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    die("Not authenticated");
}

$isAdmin = ($_SESSION["access"] === "Admin");
$currentUser = $_SESSION['user'];

// Get user ID
$stmt = $conn->prepare("SELECT uno as id FROM users WHERE username = ?");
$stmt->bind_param("s", $currentUser);
$stmt->execute();
$uRes = $stmt->get_result()->fetch_assoc();
$userId = $uRes ? $uRes['id'] : 0;

if ($userId == 0) {
    die("User not found");
}

$fileId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($fileId <= 0) {
    die("Invalid file ID");
}

$stmt = $conn->prepare("SELECT filename, file_path, uploader_id FROM mcjim_client_files WHERE id = ?");
$stmt->bind_param("i", $fileId);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();

if (!$res) {
    die("File not found");
}

if (!$isAdmin && $res['uploader_id'] != $userId) {
    die("Access denied");
}

$filePath = __DIR__ . '/uploads/secure_files/' . $res['file_path'];

if (!file_exists($filePath)) {
    die("File is missing from server");
}

// Serve the file
$mime = mime_content_type($filePath);
if ($mime === false) {
    $mime = 'application/octet-stream';
}

header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . basename($res['filename']) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filePath));
flush();
readfile($filePath);
exit;
?>
