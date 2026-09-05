<?php
require("connect.php");

$queries = [
    "CREATE TABLE IF NOT EXISTS `mcjim_monitored_servers` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `server_name` varchar(100) NOT NULL,
        `url` varchar(255) NOT NULL,
        `last_checked` datetime DEFAULT NULL,
        `status` enum('Online','Offline','Unknown') DEFAULT 'Unknown',
        `response_time_ms` int(11) DEFAULT NULL,
        `created_at` datetime NOT NULL,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `mcjim_scheduled_tasks` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `task_name` varchar(100) NOT NULL,
        `description` text,
        `scheduled_for` datetime NOT NULL,
        `status` enum('Pending','In Progress','Completed','Failed') DEFAULT 'Pending',
        `assigned_to` int(11) DEFAULT NULL,
        `created_at` datetime NOT NULL,
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

echo "Phase 4 setup complete.";
?>
