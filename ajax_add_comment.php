<?php
session_start();
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
    echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
    exit;
}

if (isset($_POST['post_id'], $_POST['comment'])) {
    $post_id = (int)$_POST['post_id'];
    $comment = trim($_POST['comment']);
    
    $inserted_id = createComment($conn, $post_id, $_SESSION['uno'], $comment);

    if ($inserted_id) {
        echo json_encode(['status' => 'OK', 'id' => $inserted_id]);
    } else {
        echo json_encode(['status' => 'ERROR', 'message' => 'Insert failed']);
    }
} else {
    echo json_encode(['status' => 'ERROR', 'message' => 'Missing post_id or comment']);
}
exit;
