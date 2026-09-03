<?php
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
  echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
  exit;
}

if(isset($_POST['post_id'])) {
  $post_id = (int)$_POST['post_id'];
  $ok = deleteBlogPost($conn, $post_id);
  echo json_encode($ok ? ['status'=>'OK'] : ['status'=>'ERROR','message'=>'Delete failed']);
} else {
  echo json_encode(['status'=>'ERROR','message'=>'Missing post_id']);
}
?>
