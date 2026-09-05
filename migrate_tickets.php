<?php
require("connect.php");

// 1. Add user_uno column to mcjim_tickets
mysqli_query($conn, "ALTER TABLE mcjim_tickets ADD COLUMN user_uno INT(11) AFTER id;");

// 2. Populate user_uno in mcjim_tickets based on username
mysqli_query($conn, "UPDATE mcjim_tickets t JOIN users u ON t.username = u.username SET t.user_uno = u.uno;");

// 3. For any tickets that didn't match (e.g. deleted users), set to 0 or leave as NULL? Let's just drop the username column.
mysqli_query($conn, "ALTER TABLE mcjim_tickets DROP COLUMN username;");

// 4. Add user_uno column to mcjim_ticket_replies
mysqli_query($conn, "ALTER TABLE mcjim_ticket_replies ADD COLUMN user_uno INT(11) AFTER ticket_id;");

// 5. Populate user_uno in mcjim_ticket_replies based on username
mysqli_query($conn, "UPDATE mcjim_ticket_replies r JOIN users u ON r.username = u.username SET r.user_uno = u.uno;");

// 6. Drop the username column from mcjim_ticket_replies
mysqli_query($conn, "ALTER TABLE mcjim_ticket_replies DROP COLUMN username;");

echo "Migration complete.";
?>
