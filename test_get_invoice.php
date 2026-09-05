<?php
require("connect.php");
$res = mysqli_query($conn, "SELECT id FROM mcjim_invoices LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    echo $row['id'];
} else {
    // Create one
    $conn->query("INSERT INTO mcjim_invoices (invoice_number, client_id, issue_date, due_date, status, created_at) VALUES ('INV-TEST', 1, '2026-01-01', '2026-01-15', 'Unpaid', NOW())");
    echo $conn->insert_id;
}
?>
