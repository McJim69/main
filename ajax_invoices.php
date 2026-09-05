<?php
require_once("connect.php");
header('Content-Type: application/json');

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$isAdmin = ($_SESSION["access"] === "Admin");
$currentUser = $_SESSION['user'];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

// Get user ID
$stmt = $conn->prepare("SELECT uno as id FROM users WHERE username = ?");
$stmt->bind_param("s", $currentUser);
$stmt->execute();
$uRes = $stmt->get_result()->fetch_assoc();
$userId = $uRes ? $uRes['id'] : 0;

if ($action == '') {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
    exit;
}

// Fetch Invoices
if ($action == 'fetch_invoices') {
    if ($isAdmin && isset($_GET['all']) && $_GET['all'] == '1') {
        $query = "SELECT i.*, u.fullname, u.username as client_username FROM mcjim_invoices i LEFT JOIN users u ON i.client_id = u.uno ORDER BY i.created_at DESC";
        $stmt = $conn->prepare($query);
    } else {
        $query = "SELECT i.*, u.fullname, u.username as client_username FROM mcjim_invoices i LEFT JOIN users u ON i.client_id = u.uno WHERE i.client_id = ? ORDER BY i.created_at DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
    }
    
    $stmt->execute();
    $result = $stmt->get_result();
    $invoices = [];
    while ($row = $result->fetch_assoc()) {
        $invoices[] = $row;
    }
    echo json_encode(['status' => 'success', 'data' => $invoices]);
    exit;
}

// Fetch single invoice with items
if ($action == 'fetch_invoice_details') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    
    $query = "SELECT i.*, u.fullname, u.username, u.email FROM mcjim_invoices i LEFT JOIN users u ON i.client_id = u.uno WHERE i.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $invRes = $stmt->get_result()->fetch_assoc();
    
    if (!$invRes) {
        echo json_encode(['status' => 'error', 'message' => 'Invoice not found']);
        exit;
    }
    
    // Check permission
    if (!$isAdmin && $invRes['client_id'] != $userId) {
        echo json_encode(['status' => 'error', 'message' => 'Access denied']);
        exit;
    }
    
    $queryItems = "SELECT * FROM mcjim_invoice_items WHERE invoice_id = ?";
    $stmt2 = $conn->prepare($queryItems);
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $itemsRes = $stmt2->get_result();
    $items = [];
    while ($it = $itemsRes->fetch_assoc()) {
        $items[] = $it;
    }
    
    $invRes['items'] = $items;
    
    echo json_encode(['status' => 'success', 'data' => $invRes]);
    exit;
}

// ADMIN ONLY ACTIONS BELOW
if (!$isAdmin) {
    echo json_encode(['status' => 'error', 'message' => 'Access denied']);
    exit;
}

// Create Invoice
if ($action == 'create_invoice') {
    $client_id = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;
    $invoice_number = isset($_POST['invoice_number']) ? trim($_POST['invoice_number']) : '';
    $issue_date = isset($_POST['issue_date']) ? $_POST['issue_date'] : '';
    $due_date = isset($_POST['due_date']) ? $_POST['due_date'] : '';
    $notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';
    
    $subtotal = isset($_POST['subtotal']) ? floatval($_POST['subtotal']) : 0;
    $tax_amount = isset($_POST['tax_amount']) ? floatval($_POST['tax_amount']) : 0;
    $total_amount = isset($_POST['total_amount']) ? floatval($_POST['total_amount']) : 0;
    
    $itemsJson = isset($_POST['items']) ? $_POST['items'] : '[]';
    $items = json_decode($itemsJson, true);
    
    if ($client_id <= 0 || empty($invoice_number) || empty($issue_date) || empty($due_date)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }
    
    // Check invoice number uniqueness
    $stmt = $conn->prepare("SELECT id FROM mcjim_invoices WHERE invoice_number = ?");
    $stmt->bind_param("s", $invoice_number);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invoice number already exists']);
        exit;
    }
    
    $now = date('Y-m-d H:i:s');
    
    // Insert invoice
    $stmt = $conn->prepare("INSERT INTO mcjim_invoices (invoice_number, client_id, issue_date, due_date, status, subtotal, tax_amount, total_amount, notes, created_at, updated_at) VALUES (?, ?, ?, ?, 'Unpaid', ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sissdddsss", $invoice_number, $client_id, $issue_date, $due_date, $subtotal, $tax_amount, $total_amount, $notes, $now, $now);
    
    if ($stmt->execute()) {
        $invoice_id = $stmt->insert_id;
        
        // Insert items
        if (is_array($items)) {
            $stmtItem = $conn->prepare("INSERT INTO mcjim_invoice_items (invoice_id, description, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
            foreach ($items as $it) {
                $desc = $it['description'];
                $qty = floatval($it['quantity']);
                $price = floatval($it['unit_price']);
                $total = $qty * $price;
                $stmtItem->bind_param("isddd", $invoice_id, $desc, $qty, $price, $total);
                $stmtItem->execute();
            }
        }
        echo json_encode(['status' => 'success', 'message' => 'Invoice created']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create invoice']);
    }
    exit;
}

// Update Invoice Status
if ($action == 'update_status') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    
    if ($id <= 0 || !in_array($status, ['Unpaid', 'Paid', 'Cancelled'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }
    
    $now = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("UPDATE mcjim_invoices SET status = ?, updated_at = ? WHERE id = ?");
    $stmt->bind_param("ssi", $status, $now, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Status updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
    }
    exit;
}

// Delete Invoice
if ($action == 'delete_invoice') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    
    // Items will be deleted manually since I didn't set ON DELETE CASCADE in Phase 3 setup script
    $stmt = $conn->prepare("DELETE FROM mcjim_invoice_items WHERE invoice_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $stmt = $conn->prepare("DELETE FROM mcjim_invoices WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Invoice deleted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete invoice']);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>
