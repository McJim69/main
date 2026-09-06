<?php
	require_once(__DIR__ . "/../connect.php");

	header('Content-Type: application/json');

	// Auth guard
	if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
		echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
		exit;
	}

	// Assign session variables
	$currentUser    = $_SESSION['user'];
	$currentUserImg = $_SESSION['imgUrl'] ?? 'blank.jpg';

	$action = isset($_GET['action']) ? $_GET['action'] : '';

	switch ($action) {
		case 'fetch_conversations':
			// Fetch all conversations (DMs and groups) that the user is a member of
			$query = "
				SELECT r.*, 
				       (SELECT message FROM mcjim_chat_messages WHERE room_id = r.id ORDER BY id DESC LIMIT 1) as last_message,
				       (SELECT sent_at FROM mcjim_chat_messages WHERE room_id = r.id ORDER BY id DESC LIMIT 1) as last_message_time,
				       (SELECT is_unsent FROM mcjim_chat_messages WHERE room_id = r.id ORDER BY id DESC LIMIT 1) as last_message_unsent
				FROM mcjim_chat_rooms r
				INNER JOIN mcjim_chat_room_members m ON r.id = m.room_id
				WHERE m.username = ?
				ORDER BY COALESCE(last_message_time, r.created_at) DESC
			";
			
			$stmt = $conn->prepare($query);
			$stmt->bind_param("s", $currentUser);
			$stmt->execute();
			$result = $stmt->get_result();
			
			$conversations = [];
			while ($row = $result->fetch_assoc()) {
				$room_id = intval($row['id']);
				$is_group = intval($row['is_group']);
				
				$name = $row['name'];
				$imgUrl = 'blank.jpg'; // default
				
				$is_online = 0;
				if (!$is_group) {
					// Private DM: find the other participant
					$memberQuery = "
						SELECT u.fullname, u.imgUrl, u.last_active 
						FROM mcjim_chat_room_members m
						INNER JOIN users u ON m.username = u.username
						WHERE m.room_id = ? AND m.username != ?
						LIMIT 1
					";
					$mStmt = $conn->prepare($memberQuery);
					$mStmt->bind_param("is", $room_id, $currentUser);
					$mStmt->execute();
					$mResult = $mStmt->get_result();
					if ($mRow = $mResult->fetch_assoc()) {
						$name = $mRow['fullname'];
						$imgUrl = !empty($mRow['imgUrl']) ? $mRow['imgUrl'] : 'blank.jpg';
						
						// Check online status (active in the last 15 seconds)
						if (!empty($mRow['last_active'])) {
							$lastActive = strtotime($mRow['last_active']);
							if ((time() - $lastActive) <= 15) {
								$is_online = 1;
							}
						}
					} else {
						$name = "Self Chat";
						$imgUrl = $currentUserImg;
						$is_online = 1; // Self is always online
					}
					$mStmt->close();
				} else {
					$name = !empty($row['name']) ? $row['name'] : "Group Chat #{$room_id}";
					$imgUrl = 'blank.jpg';
				}
				
				// Format last message preview
				$last_msg = $row['last_message'];
				if ($row['last_message_unsent']) {
					$last_msg = "This message was unsent";
				}
				
				$conversations[] = [
					'id' => $room_id,
					'name' => $name,
					'imgUrl' => $imgUrl,
					'is_group' => $is_group,
					'is_online' => $is_online,
					'last_message' => $last_msg,
					'last_message_time' => $row['last_message_time'] ? date('h:i A', strtotime($row['last_message_time'])) : '',
					'raw_time' => $row['last_message_time']
				];
			}
			$stmt->close();
			echo json_encode(['status' => 'success', 'conversations' => $conversations]);
			break;

		case 'fetch_messages':
			$room_id = isset($_GET['room_id']) ? intval($_GET['room_id']) : 0;
			
			// Verify membership
			$verifyQuery = "SELECT id FROM mcjim_chat_room_members WHERE room_id = ? AND username = ?";
			$vStmt = $conn->prepare($verifyQuery);
			$vStmt->bind_param("is", $room_id, $currentUser);
			$vStmt->execute();
			$vResult = $vStmt->get_result();
			if ($vResult->num_rows === 0) {
				echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
				exit;
			}
			$vStmt->close();
			
			// Update last_seen_message_id to the latest message in this room for this user
			$updateSeenQuery = "
				UPDATE mcjim_chat_room_members 
				SET last_seen_message_id = (
					SELECT COALESCE(MAX(id), 0) FROM mcjim_chat_messages WHERE room_id = ?
				) 
				WHERE room_id = ? AND username = ?
			";
			$usStmt = $conn->prepare($updateSeenQuery);
			if ($usStmt) {
				$usStmt->bind_param("iis", $room_id, $room_id, $currentUser);
				$usStmt->execute();
				$usStmt->close();
			}
			
			// Fetch messages
			$msgQuery = "
				SELECT m.*, u.fullname, u.imgUrl 
				FROM mcjim_chat_messages m
				INNER JOIN users u ON m.sender = u.username
				WHERE m.room_id = ?
				ORDER BY m.id ASC
			";
			$stmt = $conn->prepare($msgQuery);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$result = $stmt->get_result();
			
			$messages = [];
			while ($row = $result->fetch_assoc()) {
				$msg_id = intval($row['id']);
				
				// Fetch reactions for this message
				$reactQuery = "
					SELECT reaction, COUNT(*) as count, GROUP_CONCAT(username) as users 
					FROM mcjim_chat_reactions 
					WHERE message_id = ? 
					GROUP BY reaction
				";
				$rStmt = $conn->prepare($reactQuery);
				$rStmt->bind_param("i", $msg_id);
				$rStmt->execute();
				$rResult = $rStmt->get_result();
				$reactions = [];
				while ($rRow = $rResult->fetch_assoc()) {
					$reactions[] = [
						'reaction' => $rRow['reaction'],
						'count' => intval($rRow['count']),
						'users' => explode(',', $rRow['users'])
					];
				}
				$rStmt->close();
				
				$messages[] = [
					'id' => $msg_id,
					'sender' => $row['sender'],
					'fullname' => $row['fullname'],
					'imgUrl' => !empty($row['imgUrl']) ? $row['imgUrl'] : 'blank.jpg',
					'message' => $row['message'],
					'sent_at' => date('h:i A', strtotime($row['sent_at'])),
					'raw_sent_at' => $row['sent_at'],
					'is_unsent' => intval($row['is_unsent']),
					'is_edited' => intval($row['is_edited']),
					'reply_to' => $row['reply_to'] ? intval($row['reply_to']) : null,
					'reactions' => $reactions
				];
			}
			$stmt->close();
			
			// Fetch typing users and seen data
			$metaQuery = "SELECT m.username, last_seen_message_id, (last_typing > DATE_SUB(NOW(), INTERVAL 5 SECOND)) as is_typing, u.imgUrl FROM mcjim_chat_room_members m INNER JOIN users u ON m.username = u.username WHERE room_id = ? AND m.username != ?";
			$metaStmt = $conn->prepare($metaQuery);
			$metaStmt->bind_param("is", $room_id, $currentUser);
			$metaStmt->execute();
			$metaRes = $metaStmt->get_result();
			
			$typing_users = [];
			$seen_data = [];
			while ($mrow = $metaRes->fetch_assoc()) {
				if ($mrow['is_typing']) {
					$typing_users[] = $mrow['username'];
				}
				$seen_data[$mrow['username']] = [
				    'last_seen_message_id' => intval($mrow['last_seen_message_id']),
				    'imgUrl' => !empty($mrow['imgUrl']) ? $mrow['imgUrl'] : 'blank.jpg'
				];
			}
			$metaStmt->close();
			
			echo json_encode(['status' => 'success', 'messages' => $messages, 'typing_users' => $typing_users, 'seen_data' => $seen_data]);
			break;

		case 'send_message':
			$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
			$message = isset($_POST['message']) ? trim($_POST['message']) : '';
			$reply_to = isset($_POST['reply_to']) && !empty($_POST['reply_to']) ? intval($_POST['reply_to']) : null;

			// Message length validation (5000 char max)
			if (mb_strlen($message) > 5000) {
				echo json_encode(['status' => 'error', 'message' => 'Message is too long (max 5000 characters)']);
				exit;
			}
			
			// Verify membership
			$verifyQuery = "SELECT id FROM mcjim_chat_room_members WHERE room_id = ? AND username = ?";
			$vStmt = $conn->prepare($verifyQuery);
			$vStmt->bind_param("is", $room_id, $currentUser);
			$vStmt->execute();
			$vResult = $vStmt->get_result();
			if ($vResult->num_rows === 0) {
				echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
				exit;
			}
			$vStmt->close();
			
			// Process file attachments if uploaded
			if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
				$uploadDir = __DIR__ . '/uploads/';
				if (!file_exists($uploadDir)) {
					mkdir($uploadDir, 0777, true);
				}
				
				$fileName = basename($_FILES['file']['name']);
				$fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
				$tempName = time() . '_' . rand(1000, 9999) . '.' . $fileExt;
				$targetPath = $uploadDir . $tempName;
				$webPath = 'uploads/' . $tempName;
				
				if (move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
					$fileTag = "[FILE:{$fileName}|{$webPath}]";
					$message = empty($message) ? $fileTag : $message . "\n\n" . $fileTag;
				} else {
					echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
					exit;
				}
			}
			
			if (empty($message)) {
				echo json_encode(['status' => 'error', 'message' => 'Message is empty']);
				exit;
			}
			
			// Insert message
			$insQuery = "INSERT INTO mcjim_chat_messages (room_id, sender, message, reply_to) VALUES (?, ?, ?, ?)";
			$stmt = $conn->prepare($insQuery);
			$stmt->bind_param("issi", $room_id, $currentUser, $message, $reply_to);
			if ($stmt->execute()) {
				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to save message']);
			}
			$stmt->close();
			break;

		case 'edit_message':
			$msg_id = isset($_POST['message_id']) ? intval($_POST['message_id']) : 0;
			$new_text = isset($_POST['message']) ? trim($_POST['message']) : '';
			
			if (empty($new_text)) {
				echo json_encode(['status' => 'error', 'message' => 'Message cannot be empty']);
				exit;
			}
			
			// Verify ownership
			$ownerQuery = "SELECT sender, is_unsent FROM mcjim_chat_messages WHERE id = ?";
			$oStmt = $conn->prepare($ownerQuery);
			$oStmt->bind_param("i", $msg_id);
			$oStmt->execute();
			$oResult = $oStmt->get_result()->fetch_assoc();
			$oStmt->close();
			
			if (!$oResult || $oResult['sender'] !== $currentUser || $oResult['is_unsent'] == 1) {
				echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
				exit;
			}
			
			// Update message
			$updateQuery = "UPDATE mcjim_chat_messages SET message = ?, is_edited = 1 WHERE id = ?";
			$stmt = $conn->prepare($updateQuery);
			$stmt->bind_param("si", $new_text, $msg_id);
			if ($stmt->execute()) {
				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to edit message']);
			}
			$stmt->close();
			break;

		case 'unsend_message':
			$msg_id = isset($_POST['message_id']) ? intval($_POST['message_id']) : 0;
			
			// Verify ownership
			$ownerQuery = "SELECT sender FROM mcjim_chat_messages WHERE id = ?";
			$oStmt = $conn->prepare($ownerQuery);
			$oStmt->bind_param("i", $msg_id);
			$oStmt->execute();
			$oResult = $oStmt->get_result()->fetch_assoc();
			$oStmt->close();
			
			if (!$oResult || $oResult['sender'] !== $currentUser) {
				echo json_encode(['status' => 'error', 'message' => 'Permission denied']);
				exit;
			}
			
			// Unsend message
			$unsendQuery = "UPDATE mcjim_chat_messages SET is_unsent = 1 WHERE id = ?";
			$stmt = $conn->prepare($unsendQuery);
			$stmt->bind_param("i", $msg_id);
			if ($stmt->execute()) {
				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['status' => 'error', 'message' => 'Failed to unsend message']);
			}
			$stmt->close();
			break;

		case 'send_reaction':
			$msg_id = isset($_POST['message_id']) ? intval($_POST['message_id']) : 0;
			$reaction = isset($_POST['reaction']) ? trim($_POST['reaction']) : '';
			
			if (empty($reaction)) {
				echo json_encode(['status' => 'error', 'message' => 'Reaction cannot be empty']);
				exit;
			}
			
			// Insert reaction or update (toggles reaction)
			$checkQuery = "SELECT id, reaction FROM mcjim_chat_reactions WHERE message_id = ? AND username = ?";
			$cStmt = $conn->prepare($checkQuery);
			$cStmt->bind_param("is", $msg_id, $currentUser);
			$cStmt->execute();
			$cResult = $cStmt->get_result()->fetch_assoc();
			$cStmt->close();
			
			if ($cResult) {
				if ($cResult['reaction'] === $reaction) {
					// Toggle off
					$delQuery = "DELETE FROM mcjim_chat_reactions WHERE id = ?";
					$dStmt = $conn->prepare($delQuery);
					$dStmt->bind_param("i", $cResult['id']);
					$dStmt->execute();
					$dStmt->close();
				} else {
					// Update reaction
					$upQuery = "UPDATE mcjim_chat_reactions SET reaction = ? WHERE id = ?";
					$uStmt = $conn->prepare($upQuery);
					$uStmt->bind_param("si", $reaction, $cResult['id']);
					$uStmt->execute();
					$uStmt->close();
				}
			} else {
				// Insert new reaction
				$insQuery = "INSERT INTO mcjim_chat_reactions (message_id, username, reaction) VALUES (?, ?, ?)";
				$iStmt = $conn->prepare($insQuery);
				$iStmt->bind_param("iss", $msg_id, $currentUser, $reaction);
				$iStmt->execute();
				$iStmt->close();
			}
			echo json_encode(['status' => 'success']);
			break;

		case 'search_users':
			$term = isset($_GET['term']) ? trim($_GET['term']) : '';
			
			$search = "%{$term}%";
			$userQuery = "
				SELECT fullname, username, imgUrl, last_active 
				FROM users 
				WHERE username != ? AND (username LIKE ? OR fullname LIKE ?)
				LIMIT 10
			";
			$stmt = $conn->prepare($userQuery);
			$stmt->bind_param("sss", $currentUser, $search, $search);
			$stmt->execute();
			$result = $stmt->get_result();
			
			$users = [];
			while ($row = $result->fetch_assoc()) {
				$is_online = 0;
				if (!empty($row['last_active'])) {
					$lastActive = strtotime($row['last_active']);
					if ((time() - $lastActive) <= 15) {
						$is_online = 1;
					}
				}
				$users[] = [
					'username' => $row['username'],
					'fullname' => $row['fullname'],
					'imgUrl' => !empty($row['imgUrl']) ? $row['imgUrl'] : 'blank.jpg',
					'is_online' => $is_online
				];
			}
			$stmt->close();
			echo json_encode(['status' => 'success', 'users' => $users]);
			break;

		case 'create_room':
			$is_group = isset($_POST['is_group']) ? intval($_POST['is_group']) : 0;
			$room_name = isset($_POST['name']) ? trim($_POST['name']) : '';
			$target_username = isset($_POST['target']) ? trim($_POST['target']) : '';
			
			if (!$is_group) {
				// Private DM: check if pairing already exists
				$pairingQuery = "
					SELECT r.id 
					FROM mcjim_chat_rooms r
					INNER JOIN mcjim_chat_room_members m1 ON r.id = m1.room_id AND m1.username = ?
					INNER JOIN mcjim_chat_room_members m2 ON r.id = m2.room_id AND m2.username = ?
					WHERE r.is_group = 0
					LIMIT 1
				";
				$pStmt = $conn->prepare($pairingQuery);
				$pStmt->bind_param("ss", $currentUser, $target_username);
				$pStmt->execute();
				$pResult = $pStmt->get_result()->fetch_assoc();
				$pStmt->close();
				
				if ($pResult) {
					echo json_encode(['status' => 'success', 'room_id' => intval($pResult['id'])]);
					exit;
				}
				
				// Create new private room
				$insRoom = "INSERT INTO mcjim_chat_rooms (is_group) VALUES (0)";
				$conn->query($insRoom);
				$room_id = $conn->insert_id;
				
				// Add members
				$insMembers = "INSERT INTO mcjim_chat_room_members (room_id, username) VALUES (?, ?), (?, ?)";
				$mStmt = $conn->prepare($insMembers);
				$mStmt->bind_param("isis", $room_id, $currentUser, $room_id, $target_username);
				$mStmt->execute();
				$mStmt->close();
				
				echo json_encode(['status' => 'success', 'room_id' => $room_id]);
			} else {
				// Group chat creation
				if (empty($room_name)) {
					$room_name = "New Group Chat";
				}
				$insRoom = "INSERT INTO mcjim_chat_rooms (name, is_group) VALUES (?, 1)";
				$stmt = $conn->prepare($insRoom);
				$stmt->bind_param("s", $room_name);
				$stmt->execute();
				$room_id = $conn->insert_id;
				$stmt->close();
				
				// Add creator as member
				$insCreator = "INSERT INTO mcjim_chat_room_members (room_id, username) VALUES (?, ?)";
				$mStmt = $conn->prepare($insCreator);
				$mStmt->bind_param("is", $room_id, $currentUser);
				$mStmt->execute();
				$mStmt->close();
				
				// Add other selected members
				if (isset($_POST['members']) && is_array($_POST['members'])) {
					foreach ($_POST['members'] as $member) {
						$member = trim($member);
						if (!empty($member)) {
							$insMember = "INSERT INTO mcjim_chat_room_members (room_id, username) VALUES (?, ?)";
							$mStmt = $conn->prepare($insMember);
							$mStmt->bind_param("is", $room_id, $member);
							$mStmt->execute();
							$mStmt->close();
						}
					}
				}
				echo json_encode(['status' => 'success', 'room_id' => $room_id]);
			}
			break;

		case 'delete_group':
			$room_id = isset($_POST['room_id']) ? intval($_POST['room_id']) : 0;
			if ($room_id <= 0) {
				echo json_encode(['status' => 'error', 'message' => 'Invalid room ID']);
				break;
			}
			
			// Verify it's a group
			$chkQuery = "SELECT is_group FROM mcjim_chat_rooms WHERE id = ? LIMIT 1";
			$stmt = $conn->prepare($chkQuery);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$chkRes = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			
			if (!$chkRes || intval($chkRes['is_group']) !== 1) {
				echo json_encode(['status' => 'error', 'message' => 'Room is not a group chat']);
				break;
			}
			
			// 1. Delete reactions for messages in this room
			$delReactions = "
				DELETE FROM mcjim_chat_reactions 
				WHERE message_id IN (SELECT id FROM mcjim_chat_messages WHERE room_id = ?)
			";
			$stmt = $conn->prepare($delReactions);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$stmt->close();
			
			// 2. Delete messages
			$delMessages = "DELETE FROM mcjim_chat_messages WHERE room_id = ?";
			$stmt = $conn->prepare($delMessages);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$stmt->close();
			
			// 3. Delete room members
			$delMembers = "DELETE FROM mcjim_chat_room_members WHERE room_id = ?";
			$stmt = $conn->prepare($delMembers);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$stmt->close();
			
			// 4. Delete room itself
			$delRoom = "DELETE FROM mcjim_chat_rooms WHERE id = ?";
			$stmt = $conn->prepare($delRoom);
			$stmt->bind_param("i", $room_id);
			$stmt->execute();
			$stmt->close();
			
			echo json_encode(['status' => 'success']);
			break;

		case 'get_unread_notifications':
			// Get total unread count
			$countQuery = "
				SELECT COUNT(m.id) as unread_count, COALESCE(MAX(m.id), 0) as max_unread_id
				FROM mcjim_chat_messages m
				INNER JOIN mcjim_chat_room_members mrm ON m.room_id = mrm.room_id
				WHERE mrm.username = ?
				  AND m.sender != ?
				  AND m.id > mrm.last_seen_message_id
				  AND m.is_unsent = 0
			";
			$stmt = $conn->prepare($countQuery);
			$stmt->bind_param("ss", $currentUser, $currentUser);
			$stmt->execute();
			$countRes = $stmt->get_result()->fetch_assoc();
			$stmt->close();
			
			$unread_count = $countRes ? intval($countRes['unread_count']) : 0;
			$max_unread_id = $countRes ? intval($countRes['max_unread_id']) : 0;
			
			$latest_unread = null;
			if ($unread_count > 0) {
				// Fetch info about the latest unread message
				$latestQuery = "
					SELECT m.id, m.message, m.sender, u.fullname, u.imgUrl, m.room_id, r.name as room_name, r.is_group
					FROM mcjim_chat_messages m
					INNER JOIN mcjim_chat_room_members mrm ON m.room_id = mrm.room_id
					INNER JOIN users u ON m.sender = u.username
					INNER JOIN mcjim_chat_rooms r ON m.room_id = r.id
					WHERE mrm.username = ?
					  AND m.sender != ?
					  AND m.id > mrm.last_seen_message_id
					  AND m.is_unsent = 0
					ORDER BY m.id DESC
					LIMIT 1
				";
				$stmt = $conn->prepare($latestQuery);
				$stmt->bind_param("ss", $currentUser, $currentUser);
				$stmt->execute();
				$latestRes = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				if ($latestRes) {
					$room_name = $latestRes['room_name'];
					if (intval($latestRes['is_group']) === 0) {
						// Private DM, room name is actually the sender's fullname
						$room_name = $latestRes['fullname'];
					}
					$latest_unread = [
						'id' => intval($latestRes['id']),
						'message' => $latestRes['message'],
						'sender_name' => $latestRes['fullname'],
						'sender_avatar' => !empty($latestRes['imgUrl']) ? $latestRes['imgUrl'] : 'blank.jpg',
						'room_id' => intval($latestRes['room_id']),
						'room_name' => $room_name
					];
				}
			}
			
			echo json_encode([
				'status' => 'success',
				'unread_count' => $unread_count,
				'max_unread_id' => $max_unread_id,
				'latest_unread' => $latest_unread
			]);
			break;

		default:
			echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
			break;
	}
?>
