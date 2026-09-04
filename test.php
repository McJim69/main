<?php
require_once("jellyfin_token.php");

$username = "Guest123";
$password = "Guest123";

$server = WEB_HOST;
$param  = "Users/New";

$url = "".$server."/".$param."";

echo $url;
?>