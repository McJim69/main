<?php
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
  echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
  exit;
}

$raw_post_id = $_POST['post_id'] ?? $_POST['id'] ?? null;
if ($raw_post_id !== null) {
  $post_id     = (int)$raw_post_id;
  $user_uno    = $_SESSION['uno'];
  $user_access = $_SESSION['access'] ?? '';

  $ok = deleteBlogPost($conn, $post_id, $user_uno, $user_access);
  echo json_encode($ok ? ['status' => 'OK', 'id' => $post_id, 'post_id' => $post_id] : ['status' => 'ERROR', 'message' => 'Delete failed']);
} else {
  echo json_encode(['status' => 'ERROR', 'message' => 'Missing post_id or id']);
}
?>
