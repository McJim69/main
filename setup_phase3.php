<?php
require("connect.php");

$queries = [
    "CREATE TABLE IF NOT EXISTS `mcjim_invoices` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `invoice_number` varchar(50) NOT NULL,
        `client_id` int(11) NOT NULL,
        `issue_date` date NOT NULL,
        `due_date` date NOT NULL,
        `status` enum('Unpaid','Paid','Cancelled') DEFAULT 'Unpaid',
        `subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
        `tax_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
        `total_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
        `notes` text,
        `created_at` datetime NOT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `invoice_num_unique` (`invoice_number`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `mcjim_invoice_items` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `invoice_id` int(11) NOT NULL,
        `description` varchar(255) NOT NULL,
        `quantity` decimal(10,2) NOT NULL DEFAULT '1.00',
        `unit_price` decimal(10,2) NOT NULL DEFAULT '0.00',
        `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
];

foreach ($queries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Query executed successfully.<br>";
    } else {
        echo "Error: " . mysqli_error($conn) . "<br>";
    }
}

echo "Phase 3 setup complete.";
?>
