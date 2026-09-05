<?php
require("connect.php");

if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
    echo "Not authenticated";
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "Invalid invoice ID";
    exit;
}

$isAdmin = ($_SESSION["access"] === "Admin");
$userId = $_SESSION['id'] ?? 0;

if ($userId == 0) {
    // Fallback if session ID isn't set
    $stmt = $conn->prepare("SELECT uno as id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['user']);
    $stmt->execute();
    $uRes = $stmt->get_result()->fetch_assoc();
    $userId = $uRes ? $uRes['id'] : 0;
}

$query = "SELECT i.*, u.fullname, u.username FROM mcjim_invoices i LEFT JOIN users u ON i.client_id = u.uno WHERE i.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$inv = $stmt->get_result()->fetch_assoc();

if (!$inv) {
    echo "Invoice not found";
    exit;
}

if (!$isAdmin && $inv['client_id'] != $userId) {
    echo "Access denied";
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?php echo $inv['invoice_number']; ?></title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            color: #333;
            font-family: 'Inter', sans-serif;
            padding: 40px;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background: #fff;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            border-bottom: 2px solid #a4c639; /* Brand color */
            padding-bottom: 20px;
        }
        .header img {
            max-height: 60px;
            filter: invert(1); /* So white logo shows on light background, or use dark logo */
            background: #222;
            padding: 10px;
            border-radius: 5px;
        }
        .invoice-details {
            text-align: right;
        }
        .address-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .table {
            margin-bottom: 30px;
        }
        .table th {
            background: #f8f9fa;
        }
        .totals {
            width: 100%;
            max-width: 300px;
            margin-left: auto;
        }
        .totals td {
            padding: 5px 0;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 20px;
        }
        .status.paid { color: #28a745; }
        .status.unpaid { color: #dc3545; }
        .status.cancelled { color: #6c757d; }
        
        @media print {
            body { padding: 0; background: #fff; }
            .invoice-box { box-shadow: none; border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div class="text-center mb-4 no-print">
    <button class="btn btn-primary" onclick="window.print()">Print / Save as PDF</button>
</div>

<div class="invoice-box">
    <div class="header">
        <div>
            <img src="images/header_logo1.png" alt="McJim Cyberworks">
            <h4 class="mt-3">McJim Cyberworks</h4>
            <p>123 Cyber St, Web City<br>
            info@mcjim-server.com<br>
            +639776848642</p>
        </div>
        <div class="invoice-details">
            <h1 style="color:#a4c639;">INVOICE</h1>
            <h4><?php echo $inv['invoice_number']; ?></h4>
            <p><strong>Issue Date:</strong> <?php echo $inv['issue_date']; ?><br>
               <strong>Due Date:</strong> <?php echo $inv['due_date']; ?></p>
            <div class="status <?php echo strtolower($inv['status']); ?>"><?php echo $inv['status']; ?></div>
        </div>
    </div>
    
    <div class="address-box">
        <div>
            <h5 style="color:#777;">BILL TO:</h5>
            <strong><?php echo $inv['fullname'] ?: $inv['username']; ?></strong>
        </div>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($items as $item) { ?>
            <tr>
                <td><?php echo htmlspecialchars($item['description']); ?></td>
                <td class="text-center"><?php echo $item['quantity']; ?></td>
                <td class="text-right">$<?php echo number_format($item['unit_price'], 2); ?></td>
                <td class="text-right">$<?php echo number_format($item['total_price'], 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <table class="totals">
        <tr>
            <td><strong>Subtotal:</strong></td>
            <td class="text-right">$<?php echo number_format($inv['subtotal'], 2); ?></td>
        </tr>
        <tr>
            <td><strong>Tax:</strong></td>
            <td class="text-right">$<?php echo number_format($inv['tax_amount'], 2); ?></td>
        </tr>
        <tr>
            <td style="border-top:2px solid #333; padding-top:10px;"><h5>Total:</h5></td>
            <td class="text-right" style="border-top:2px solid #333; padding-top:10px;"><h5>$<?php echo number_format($inv['total_amount'], 2); ?></h5></td>
        </tr>
    </table>
    
    <?php if(!empty($inv['notes'])) { ?>
    <div style="margin-top: 40px; padding:15px; background:#f9f9f9; border-left:4px solid #a4c639;">
        <h5>Notes / Instructions</h5>
        <p style="margin:0; white-space:pre-wrap;"><?php echo htmlspecialchars($inv['notes']); ?></p>
    </div>
    <?php } ?>
</div>

</body>
</html>
