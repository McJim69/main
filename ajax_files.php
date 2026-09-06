<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
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
    echo json_encode(['status' => 'error', 'message' => 'User not found']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action == '') {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    exit;
}

// Fetch Files
if ($action == 'fetch_files') {
    if ($isAdmin && isset($_GET['all']) && $_GET['all'] == '1') {
        $query = "SELECT f.*, u.fullname, u.username as uploader_username FROM mcjim_client_files f LEFT JOIN users u ON f.uploader_id = u.uno ORDER BY f.uploaded_at DESC";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT f.*, u.fullname, u.username as uploader_username FROM mcjim_client_files f LEFT JOIN users u ON f.uploader_id = u.uno WHERE f.uploader_id = ? ORDER BY f.uploaded_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $files = [];
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $files]);
    exit;
}

// Upload File
if ($action == 'upload') {
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload failed or no file selected']);
        exit;
    }

    $file = $_FILES['file'];
    $filename = basename($file['name']);
    $fileSize = $file['size'];
    $projectId = isset($_POST['project_id']) ? intval($_POST['project_id']) : 0;
    
    // Validate file extension to block dangerous files
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $blocked = ['php', 'php3', 'php4', 'php5', 'phtml', 'exe', 'sh', 'bat', 'cmd', 'ps1', 'vbs'];
    if (in_array($ext, $blocked)) {
        echo json_encode(['status' => 'error', 'message' => 'File type not allowed']);
        exit;
    }
    
    $uploadDir = __DIR__ . '/uploads/secure_files/';
    if (!is_dir($uploadDir)) {
        if (!mkdir($uploadDir, 0755, true)) {
            echo json_encode(['status' => 'error', 'message' => 'Upload directory could not be created. Please contact the administrator.']);
            exit;
        }
    }
    if (!is_writable($uploadDir)) {
        echo json_encode(['status' => 'error', 'message' => 'Upload directory is not writable. Please contact the administrator.']);
        exit;
    }
    // Generate a secure, unique filename to prevent overwriting and guessing
    $secureName = uniqid() . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
    $destPath = $uploadDir . $secureName;
    
    if (move_uploaded_file($file['tmp_name'], $destPath)) {
        $now = date('Y-m-d H:i:s');
        $stmt = $conn->prepare("INSERT INTO mcjim_client_files (filename, file_path, file_size, uploader_id, project_id, uploaded_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiis", $filename, $secureName, $fileSize, $userId, $projectId, $now);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
        } else {
            // Delete file if DB insert fails
            unlink($destPath);
            echo json_encode(['status' => 'error', 'message' => 'Database error during upload']);
        }
    } else {
        $error = error_get_last();
        $errMsg = $error ? $error['message'] : 'Unknown error';
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file: ' . $errMsg]);
    }
    exit;
}

// Delete File
if ($action == 'delete') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    // Check ownership or admin
    $stmt = $conn->prepare("SELECT file_path, uploader_id FROM mcjim_client_files WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    
    if (!$res) {
        echo json_encode(['status' => 'error', 'message' => 'File not found']);
        exit;
    }
    
    if (!$isAdmin && $res['uploader_id'] != $userId) {
        echo json_encode(['status' => 'error', 'message' => 'Access denied']);
        exit;
    }
    
    $filePath = __DIR__ . '/uploads/secure_files/' . $res['file_path'];
    
    $stmt = $conn->prepare("DELETE FROM mcjim_client_files WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        echo json_encode(['status' => 'success', 'message' => 'File deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete file record']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
