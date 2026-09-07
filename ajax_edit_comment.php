<?php
require_once("connect.php");
require_once("crud_functions.php");

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['uno'])) {
	echo json_encode(['status' => 'ERROR', 'message' => 'You must be logged in']);
	exit;
}

$comment_id  = (int)($_POST['comment_id'] ?? 0);
$comment     = trim($_POST['comment'] ?? '');
$user_uno    = $_SESSION['uno'];
$user_access = $_SESSION['access'] ?? '';

if (!$comment_id || strlen($comment) === 0) {
	echo json_encode(['status' => 'ERROR', 'message' => 'Missing comment or content payload']);
	exit;
}

$ok = updateComment($conn, $comment_id, $comment, $user_uno, $user_access);
if ($ok) {
	echo json_encode([
	  'status' => 'OK',
	  'comment_id' => $comment_id
	]);
} else {
	echo json_encode(['status' => 'ERROR', 'message' => 'Failed to update comment']);
}
exit;
?>
