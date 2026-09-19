<?php
require_once("jellyfin_helper.php");
$token = get_jellyfin_token("jcmcy", "invalid_password");
var_dump($token);
