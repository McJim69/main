<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

// Kanban is usually internal/admin facing, but we might allow staff to use it.
// Assuming only admins can manage the board for now.
$isAdmin = ($_SESSION["access"] === "Admin");
if (!$isAdmin) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'fetch_tasks':
        $query = "SELECT t.*, u.fullname, u.imgUrl FROM mcjim_tasks t LEFT JOIN users u ON t.assigned_to = u.username ORDER BY t.created_at ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $tasks = [
            'To Do' => [],
            'In Progress' => [],
            'Review' => [],
            'Done' => []
        ];
        
        while ($row = $result->fetch_assoc()) {
            $row['due_date_formatted'] = $row['due_date'] ? date('M d', strtotime($row['due_date'])) : '';
            $row['imgUrl'] = empty($row['imgUrl']) ? 'blank.jpg' : $row['imgUrl'];
            if (isset($tasks[$row['status']])) {
                $tasks[$row['status']][] = $row;
            }
        }
        $stmt->close();
        echo json_encode(['status' => 'success', 'tasks' => $tasks]);
        break;

    case 'create_task':
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $assigned_to = trim($_POST['assigned_to'] ?? '');
        $status = trim($_POST['status'] ?? 'To Do');
        $due_date = trim($_POST['due_date'] ?? '');
        
        if (empty($title)) {
            echo json_encode(['status' => 'error', 'message' => 'Title is required.']);
            exit;
        }
        
        if (empty($due_date)) $due_date = null;
        if (empty($assigned_to)) $assigned_to = null;

        $stmt = $conn->prepare("INSERT INTO mcjim_tasks (title, description, assigned_to, status, due_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $assigned_to, $status, $due_date);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to create task']);
        }
        $stmt->close();
        break;

    case 'update_status':
        $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $status = $_POST['status'] ?? '';
        
        $valid_statuses = ['To Do', 'In Progress', 'Review', 'Done'];
        if (in_array($status, $valid_statuses)) {
            $stmt = $conn->prepare("UPDATE mcjim_tasks SET status = ? WHERE id = ?");
            $stmt->bind_param("si", $status, $task_id);
            $stmt->execute();
            $stmt->close();
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid status']);
        }
        break;
        
    case 'delete_task':
        $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
        $stmt = $conn->prepare("DELETE FROM mcjim_tasks WHERE id = ?");
        $stmt->bind_param("i", $task_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
        }
        $stmt->close();
        break;

    case 'search_users':
        $term = isset($_GET['term']) ? trim($_GET['term']) : '';
        $search = "%{$term}%";
        $stmt = $conn->prepare("SELECT username, fullname, imgUrl FROM users WHERE status='active' AND (username LIKE ? OR fullname LIKE ?) LIMIT 10");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $row['imgUrl'] = empty($row['imgUrl']) ? 'blank.jpg' : $row['imgUrl'];
            $users[] = $row;
        }
        $stmt->close();
        echo json_encode(['status' => 'success', 'users' => $users]);
        break;

    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        break;
}
?>
