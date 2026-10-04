<?php
require("connect.php");

header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = trim($_GET['username']);
    
    // Quick sanitization
    $username = preg_replace('/[^a-zA-Z0-9._-]/', '', strtolower($username));

    if (empty($username)) {
        echo json_encode(["available" => false]);
        exit;
    }

    $stmt = $conn->prepare("SELECT uno FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo json_encode(["available" => false]);
    } else {
        echo json_encode(["available" => true]);
    }
    
    $stmt->close();
} else {
    echo json_encode(["available" => false]);
}
?>
