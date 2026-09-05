<?php
require("connect.php");
$stmt = $conn->prepare("SELECT * FROM users WHERE uno = ?");
$val = 1;
$arr = [1];
try {
    $stmt->bind_param("i", ...$arr);
    $stmt->execute();
    echo "Success";
} catch (Exception $e) {
    echo "Ex: " . $e->getMessage();
} catch (Error $e) {
    echo "Err: " . $e->getMessage();
}
?>
