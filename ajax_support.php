<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$currentUser = $_SESSION['user'];
$currentUserUno = $_SESSION['uno'];
$isAdmin = ($_SESSION["access"] === "Admin");
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'fetch_tickets':
        if ($isAdmin && isset($_GET['all']) && $_GET['all'] == '1') {
            $query = "SELECT t.*, u.fullname, u.username FROM mcjim_tickets t LEFT JOIN users u ON t.user_uno = u.uno ORDER BY t.updated_at DESC";
            $stmt = $conn->prepare($query);
        } else {
            $query = "SELECT t.*, u.fullname, u.username FROM mcjim_tickets t LEFT JOIN users u ON t.user_uno = u.uno WHERE t.user_uno = ? ORDER BY t.updated_at DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $currentUserUno);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $tickets = [];
        while ($row = $result->fetch_assoc()) {
            $row['created_at'] = date('M d, Y h:i A', strtotime($row['created_at']));
            $row['updated_at'] = date('M d, Y h:i A', strtotime($row['updated_at']));
            $tickets[] = $row;
        }
        $stmt->close();
        echo json_encode(['status' => 'success', 'tickets' => $tickets]);
        break;

    case 'create_ticket':
        $subject = trim($_POST['subject'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $priority = trim($_POST['priority'] ?? 'Medium');

        if (empty($subject) || empty($description)) {
            echo json_encode(['status' => 'error', 'message' => 'Subject and Description are required.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO mcjim_tickets (user_uno, subject, description, priority) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $currentUserUno, $subject, $description, $priority);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create ticket']);
        }
        $stmt->close();
        break;

    case 'fetch_ticket':
        $ticket_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        
        // Verify ownership or admin
        $stmt = $conn->prepare("SELECT t.*, u.fullname, u.imgUrl, u.username FROM mcjim_tickets t LEFT JOIN users u ON t.user_uno = u.uno WHERE t.id = ?");
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $ticket = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if (!$ticket || (!$isAdmin && (int)$ticket['user_uno'] !== (int)$currentUserUno)) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized or not found']);
            exit;
        }

        $ticket['created_at'] = date('M d, Y h:i A', strtotime($ticket['created_at']));

        // Fetch replies
        $stmt = $conn->prepare("SELECT r.*, u.fullname, u.imgUrl, u.access, u.username FROM mcjim_ticket_replies r LEFT JOIN users u ON r.user_uno = u.uno WHERE r.ticket_id = ? ORDER BY r.created_at ASC");
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $replies = [];
        while ($row = $res->fetch_assoc()) {
            $row['created_at'] = date('M d, Y h:i A', strtotime($row['created_at']));
            $row['imgUrl'] = empty($row['imgUrl']) ? 'blank.jpg' : $row['imgUrl'];
            $replies[] = $row;
        }
        $stmt->close();

        echo json_encode(['status' => 'success', 'ticket' => $ticket, 'replies' => $replies]);
        break;

    case 'add_reply':
        $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
        $message = trim($_POST['message'] ?? '');

        if (empty($message)) {
            echo json_encode(['status' => 'error', 'message' => 'Message is empty']);
            exit;
        }

        // Verify ticket access
        $stmt = $conn->prepare("SELECT user_uno, status FROM mcjim_tickets WHERE id = ?");
        $stmt->bind_param("i", $ticket_id);
        $stmt->execute();
        $ticket = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if (!$ticket || (!$isAdmin && (int)$ticket['user_uno'] !== (int)$currentUserUno)) {
            echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
            exit;
        }

        // Add reply
        $stmt = $conn->prepare("INSERT INTO mcjim_ticket_replies (ticket_id, user_uno, message) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $ticket_id, $currentUserUno, $message);
        if ($stmt->execute()) {
            // Update ticket status if admin replied and it's open
            if ($isAdmin && $ticket['status'] === 'Open') {
                $conn->query("UPDATE mcjim_tickets SET status = 'In Progress' WHERE id = " . $ticket_id);
            }
            // Update timestamp
            $conn->query("UPDATE mcjim_tickets SET updated_at = NOW() WHERE id = " . $ticket_id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add reply']);
        }
        break;

    case 'update_status':
        if (!$isAdmin) {
            echo json_encode(['status' => 'error', 'message' => 'Admin only']);
            exit;
        }
        $ticket_id = isset($_POST['ticket_id']) ? intval($_POST['ticket_id']) : 0;
        $status = $_POST['status'] ?? '';
        
        $valid_statuses = ['Open', 'In Progress', 'Resolved', 'Closed'];
        if (in_array($status, $valid_statuses)) {
            $stmt = $conn->prepare("UPDATE mcjim_tickets SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $ticket_id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
        }
        break;
        
    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>
