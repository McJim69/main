<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

if ($_SESSION["access"] !== "Admin") {
    echo json_encode(['status' => 'error', 'message' => 'Access denied']);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action == '') {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    exit;
}

// Fetch Tasks
if ($action == 'fetch_tasks') {
    $query = "SELECT t.*, u.fullname, u.username as assigned_username FROM mcjim_scheduled_tasks t LEFT JOIN users u ON t.assigned_to = u.uno ORDER BY t.scheduled_for ASC";
    $result = mysqli_query($conn, $query);
    $tasks = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $tasks]);
    exit;
}

// Add Task
if ($action == 'add_task') {
    $name = isset($_POST['task_name']) ? trim($_POST['task_name']) : '';
    $desc = isset($_POST['description']) ? trim($_POST['description']) : '';
    $scheduled_for = isset($_POST['scheduled_for']) ? $_POST['scheduled_for'] : '';
    $assigned_to = isset($_POST['assigned_to']) ? intval($_POST['assigned_to']) : 0;
    
    if (empty($name) || empty($scheduled_for)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and Schedule Time are required']);
        exit;
    }
    
    if ($assigned_to == 0) $assigned_to = null;
    
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO mcjim_scheduled_tasks (task_name, description, scheduled_for, status, assigned_to, created_at) VALUES (?, ?, ?, 'Pending', ?, ?)");
    $stmt->bind_param("sssis", $name, $desc, $scheduled_for, $assigned_to, $now);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task scheduled']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to schedule task']);
    }
    exit;
}

// Update Task Status
if ($action == 'update_status') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    if ($id <= 0 || !in_array($status, ['Pending', 'In Progress', 'Completed', 'Failed'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE mcjim_scheduled_tasks SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task status updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
    }
    exit;
}

// Delete Task
if ($action == 'delete_task') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    
    $stmt = $conn->prepare("DELETE FROM mcjim_scheduled_tasks WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Task deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete task']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
