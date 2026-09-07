<?php
//=====================//
// ajax_edit_post.php  //
//=====================//
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if (!isset($_SESSION['uno'])) {
  echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
  exit;
}

$raw_post_id = $_POST['post_id'] ?? $_POST['id'] ?? null;
if ($raw_post_id !== null && isset($_POST['title'])) {
  $post_id     = (int)$raw_post_id;
  $title       = trim($_POST['title']);
  $content     = $_POST['content'] ?? ''; 
  $user_uno    = $_SESSION['uno'];
  $user_access = $_SESSION['access'] ?? '';
  $images      = [];

  // Security Configuration Constraints
  $maxFileSize  = 10485760; // 10MB
  $allowedExts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

  if (isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      if (!isset($_FILES['images']['error'][$key]) || $_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
        continue; 
      }
        
      if ($_FILES['images']['size'][$key] > $maxFileSize) {
        echo json_encode(['status' => 'ERROR', 'message' => 'One or more images exceed the 10MB limit.']);
        exit;
      }

      $fileName = $_FILES['images']['name'][$key];
      $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      if (!in_array($fileExt, $allowedExts)) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid file extension format.']);
        exit;
      }

      if (class_exists('finfo')) {
        $finfo    = new finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($tmp_name);
      } else {
        $imgInfo  = getimagesize($tmp_name);
        $realMime = $imgInfo ? $imgInfo['mime'] : '';
      }

      if (!in_array($realMime, $allowedMimes)) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid image structure layout.']);
        exit;
      }

      $upload_dir = __DIR__."/uploads/";
      if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, 0755, true);
      }

      $safe_base = preg_replace("/[^A-Za-z0-9\-_.]/", '', basename($fileName));
      $file_name = time().'_'.$key.'_'.$safe_base;
      $target    = $upload_dir . $file_name;
      
      if (move_uploaded_file($tmp_name, $target)) {
        if (function_exists('convertAndResizeToWebp')) {
          $convertedPath = convertAndResizeToWebp($target, 1920, 1920, 80);
          $images[] = "uploads/" . basename($convertedPath); 
          
          $sourceClean    = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $target);
          $convertedClean = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $convertedPath);
          
          if ($sourceClean !== $convertedClean && file_exists($sourceClean)) {
              @unlink($sourceClean);
          }
        } else {
          $images[] = "uploads/" . $file_name;
        }
      }
    }
  }

  $ok = updateBlogPostWithImages($conn, $post_id, $title, $content, $user_uno, $images, $user_access);
  
  if ($ok) {
    echo json_encode([
      'status'    => 'OK',
      'id'        => $post_id,
      'post_id'   => $post_id,
      'posted_id' => $post_id,
      'message'   => 'Post updated successfully'
    ]);
  } else {
    echo json_encode(['status' => 'ERROR', 'message' => 'Update failed. Verify database constraints or permissions.']);
  }
} else {
  echo json_encode(['status' => 'ERROR', 'message' => 'Missing payload fields on server request.']);
}
exit;
?>
