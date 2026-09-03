<?php
//ajax_get_images.php
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if(isset($_GET['post_id'])) {
  $post_id = (int)$_GET['post_id'];
  $images = getPostImages($conn, $post_id);
  echo json_encode(['status'=>'OK','images'=>$images]);
} else {
  echo json_encode(['status'=>'ERROR','message'=>'Missing post_id']);
}
?>
