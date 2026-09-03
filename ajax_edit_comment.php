<?php
	require_once("connect.php");
	require_once("crud_functions.php");

	header('Content-Type: application/json; charset=utf-8');

	$comment_id = $_POST['comment_id'] ?? 0;
	$comment    = $_POST['comment'] ?? '';

	if (!$comment_id || !$comment) {
		echo json_encode(['status' => 'ERROR', 'message' => 'Missing data']);
		exit;
	}

	$ok = updateComment($conn, $comment_id, $comment);
	$post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
	if ($ok) {
		echo json_encode([
		  'status' => 'OK',
		  'comment_id' => $comment_id,
		  'post_id' => $post_id
		]);
	} else {
		echo json_encode(['status' => 'ERROR', 'message' => 'Failed to update']);
	}
	exit;
