<?php
//=====================//
// ajax_add_post.php   //
//=====================//
// Need to be enabled: //
// ;extension=fileinfo //
// ;extension=gd       //
//=====================//
session_start();
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json');

if(!isset($_SESSION['uno'])) {
  echo json_encode(['status'=>'ERROR','message'=>'You must be logged in']);
  exit;
}

// Helper Function for Resizing and WebP Conversion
function convertAndResizeToWebp($sourcePath, $maxWidth = 1920, $maxHeight = 1920, $quality = 80) {
  // Check if GD extension functions exist before executing
  if (!function_exists('imagecreatetruecolor')) {
    return $sourcePath; // Fallback to original if GD is missing
  }

  $info = getimagesize($sourcePath);
  if (!$info) return $sourcePath;

  $mime = $info['mime'];
  switch ($mime) {
    case 'image/jpeg': 
    case 'image/jpg': // Fallback mapping
      $srcImage = @imagecreatefromjpeg($sourcePath); 
      break;
    case 'image/png':  
      $srcImage = @imagecreatefrompng($sourcePath); 
      break;
    case 'image/gif':  
      $srcImage = @imagecreatefromgif($sourcePath); 
      break;
    case 'image/webp': 
      if (function_exists('imagecreatefromwebp')) {
        $srcImage = @imagecreatefromwebp($sourcePath); 
      } else {
        return $sourcePath;
      }
      break;
    default: return $sourcePath;
  }

  if (!$srcImage) return $sourcePath;

  $origWidth  = imagesx($srcImage);
  $origHeight = imagesy($srcImage);

  $ratio = $origWidth / $origHeight;
  $newWidth  = $origWidth;
  $newHeight = $origHeight;

  if ($newWidth > $maxWidth) {
    $newWidth  = $maxWidth;
    $newHeight = round($newWidth / $ratio);
  }

  if ($newHeight > $maxHeight) {
    $newHeight = $maxHeight;
    $newWidth  = round($newHeight * $ratio);
  }

  $finalImage = imagecreatetruecolor($newWidth, $newHeight);

  if ($mime == 'image/png' || $mime == 'image/webp' || $mime == 'image/gif') {
    imagealphablending($finalImage, false);
    imagesavealpha($finalImage, true);
  }

  imagecopyresampled($finalImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

  $pathInfo = pathinfo($sourcePath);
  $webpPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

  // Check if WebP output is supported by the server
  if (function_exists('imagewebp')) {
    if (imagewebp($finalImage, $webpPath, $quality)) {
      imagedestroy($srcImage);
      imagedestroy($finalImage);

      if (cleanPath($sourcePath) !== cleanPath($webpPath) && file_exists($sourcePath)) {
        @unlink($sourcePath);
      }
      return $webpPath;
    }
  }

  imagedestroy($srcImage);
  imagedestroy($finalImage);
  return $sourcePath;
}

// Quick helper to safely compare file system paths
function cleanPath($path) {
    return str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
}

if(isset($_POST['title'], $_POST['content'])) {
  $title   = trim($_POST['title']);
  $content = $_POST['content'];
  $images  = []; //  Fixed array initialization

  // Security Configuration Allowances
  $maxFileSize  = 10485760; // 10MB
  $allowedExts  = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
  $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

  if(isset($_FILES['images']) && is_array($_FILES['images']['tmp_name'])) {
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
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid file extension formatting.']);
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
        echo json_encode(['status' => 'ERROR', 'message' => 'Invalid binary image format.']);
        exit;
      }

      $safe_base = preg_replace("/[^A-Za-z0-9\-_.]/", '', basename($fileName));
      $file_name = time().'_'.$key.'_'.$safe_base;
      $target = __DIR__."/uploads/".$file_name;
      
      if(move_uploaded_file($tmp_name, $target)) {
        $convertedPath = convertAndResizeToWebp($target, 1920, 1920, 80);
        $images[] = "uploads/" . basename($convertedPath); 
      }
    }
  }

  // Pass variables directly down to database abstraction utility
  $post_id = createBlogPost($conn, $_SESSION['uno'], $title, $content, $images);

  echo json_encode($post_id ? ['status'=>'OK','id'=>$post_id] : ['status'=>'ERROR','message'=>'Insert failed']);
} else {
  echo json_encode(['status'=>'ERROR','message'=>'Missing title or content']);
}
?>
