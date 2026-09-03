<?php
	session_start();
	require_once("connect.php");
	require_once("crud_functions.php");

	header('Content-Type: application/json');

	if(isset($_POST['image_id'])) {
	  $image_id = (int)$_POST['image_id'];
	  $user_uno = $_SESSION['uno'] ?? null;
	  $user_access = $_SESSION['access'] ?? '';

	  // Get owner of the image
	  $stmt = $conn->prepare("SELECT uploaded_by FROM post_images WHERE id=?");
	  $stmt->bind_param("i", $image_id);
	  $stmt->execute();
	  $stmt->bind_result($image_owner);
	  $stmt->fetch();
	  $stmt->close();

	  if(!$image_owner) {
		echo json_encode(['status'=>'ERROR','message'=>'Image not found']);
		exit;
	  }

	  // Authorization check: only Admin or owner
	  if($user_access === 'Admin' || $user_uno === $image_owner) {
		$ok = deletePostImage($conn, $image_id);
		echo json_encode($ok ? ['status'=>'OK'] : ['status'=>'ERROR','message'=>'Delete failed']);
	  } else {
		http_response_code(403);
		echo json_encode(['status'=>'ERROR','message'=>'Unauthorized delete attempt']);
	  }

	} else {
	  echo json_encode(['status'=>'ERROR','message'=>'Missing image_id']);
	}
?>
