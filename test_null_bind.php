<?php
require("connect.php");
$stmt = $conn->prepare("SELECT * FROM users WHERE uno = ?");
$val = null;
try {
    $stmt->bind_param("i", $val);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_all();
    echo "Success: " . count($res);
} catch (Exception $e) {
    echo "Ex: " . $e->getMessage();
} catch (Error $e) {
    echo "Err: " . $e->getMessage();
}
?>
