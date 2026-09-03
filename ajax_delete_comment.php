<?php
session_start();
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
    echo json_encode(['status' => 'ERROR', 'message' => 'Not logged in']);
    exit;
}

if (isset($_POST['comment_id'])) {
    $comment_id = (int)$_POST['comment_id'];

    if (deleteComment($conn, $comment_id, $_SESSION['uno'])) {
        echo json_encode(['status' => 'OK']);
    } else {
        echo json_encode(['status' => 'ERROR', 'message' => 'Delete failed']);
    }
} else {
    echo json_encode(['status' => 'ERROR', 'message' => 'Missing comment_id']);
}
exit;
