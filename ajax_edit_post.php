<?php
// ajax_edit_post.php
ob_start();
session_start();

require_once("connect.php");
require_once("crud_functions.php"); // Crucial: ensure convertAndResizeToWebp() is shared here

ob_clean();
header('Content-Type: application/json');

if(!isset($_SESSION['uno'])) {
  echo json_encode(['status'=>'ERROR','message'=>'You must be logged in']);
  exit;
}

// FIXED: Looking for 'post_id' matching your frontend FormData key perfectly
if(isset($_POST['post_id'], $_POST['title'])) {
  $post_id = (int)$_POST['post_id'];
  $title   = trim($_POST['title']);
  $content = $_POST['content'] ?? ''; 
  $images  = [];

  // Security Configuration Constraints
  $maxFileSize  = 10485760; // 10MB
  $allowedExts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

  if(isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
      
      // Ensure array values exist before iterating
      if (!isset($_FILES['images']['error'][$key]) || $_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
        continue; 
      }
        
      // 1. File Size Verification
      if ($_FILES['images']['size'][$key] > $maxFileSize) {
        echo json_encode(['status' => 'ERROR', 'message' => 'One or more images exceed the 10MB limit.']);
        exit;
      }

      // 2. Extension Filtering
      $fileName = $_FILES['images']['name'][$key];
      $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
      if (!in_array($fileExt, $allowedExts)) {
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid file extension format.']);
        exit;
      }

      // 3. Binary Magic Byte Validation
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

      // Setup write directories securely
      $upload_dir = __DIR__."/uploads/";
      if (!is_dir($upload_dir)) {
        @mkdir($upload_dir, 0755, true);
      }

      // 4. File Normalization
      $safe_base = preg_replace("/[^A-Za-z0-9\-_.]/", '', basename($fileName));
      $file_name = time().'_'.$key.'_'.$safe_base;
      $target = $upload_dir . $file_name;
      
      if(move_uploaded_file($tmp_name, $target)) {
 
	  // 5. Downscale and Convert to WebP format
        if (function_exists('convertAndResizeToWebp')) {
          $convertedPath = convertAndResizeToWebp($target, 1920, 1920, 80);
          
          // Capture the clean webp image path for the database
          $images[] = "uploads/" . basename($convertedPath); 
          
          // FIXED: Hardened cleanup safeguard to delete the original non-webp image from your folder
          $sourceClean = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $target);
          $convertedClean = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $convertedPath);
          
          if ($sourceClean !== $convertedClean && file_exists($sourceClean)) {
              @unlink($sourceClean); // Force delete the leftover .jpg / .png file
          }
        } else {
          $images[] = "uploads/" . $file_name;
        }
      }
    }
  }

  // Update records utilizing your stable, owner-enforced database function
  $ok = updateBlogPostWithImages($conn, $post_id, $title, $content, $images, $_SESSION['uno']);
  
  if ($ok) {
    echo json_encode(['status'=>'OK', 'id'=>$post_id, 'message'=>'Post updated successfully']);
  } else {
    echo json_encode(['status'=>'ERROR', 'message'=>'Update failed. Verify database constraints or permissions.']);
  }
} else {
  echo json_encode(['status'=>'ERROR', 'message'=>'Missing payload fields on server request.']);
}
exit;
