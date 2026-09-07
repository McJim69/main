<?php
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
    echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
    exit;
}

if (isset($_POST['comment_id'])) {
    $comment_id  = (int)$_POST['comment_id'];
    $user_uno    = $_SESSION['uno'];
    $user_access = $_SESSION['access'] ?? '';

    if (deleteComment($conn, $comment_id, $user_uno, $user_access)) {
        echo json_encode(['status' => 'OK']);
    } else {
        echo json_encode(['status' => 'ERROR', 'message' => 'Delete failed']);
    }
} else {
    echo json_encode(['status' => 'ERROR', 'message' => 'Missing comment_id']);
}
exit;
?>
