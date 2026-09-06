<?php
require_once '../connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
	echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
	exit;
}

$currentUser = $_SESSION['user'];
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($action) {
	case 'set_typing':
		$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
		$is_typing = isset($_POST['is_typing']) && $_POST['is_typing'] == '1' ? true : false;
		
		if ($is_typing) {
		    $query = "UPDATE mcjim_chat_room_members SET last_typing = CURRENT_TIMESTAMP WHERE room_id = ? AND username = ?";
		} else {
		    $query = "UPDATE mcjim_chat_room_members SET last_typing = NULL WHERE room_id = ? AND username = ?";
		}
		
		$stmt = $conn->prepare($query);
		$stmt->bind_param("is", $room_id, $currentUser);
		$stmt->execute();
		$stmt->close();
		
		echo json_encode(['status' => 'success']);
		break;
		
	default:
		echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
		break;
}
?>
