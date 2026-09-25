<?php
$token = $_GET['token'] ?? '';
if (empty($token)) {
    die('Invalid or missing SSO token.');
}

$token = preg_replace('/[^a-zA-Z0-9]/', '', $token);
$cacheDir = __DIR__ . '/../library/Server/Manager/cache/';
$tokenFile = $cacheDir . 'sso_' . $token;

if (!file_exists($tokenFile)) {
    die('Token expired or invalid.');
}

$data = json_decode(file_get_contents($tokenFile), true);
if (!$data) {
    die('Invalid token data.');
}

$host = $data['host'];
$username = $data['username'];
$password = $data['password'];
$actionUrl = $host . '/api/loginAPI';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Logging into CyberPanel...</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; background-color: #f4f5f7; }
        .loader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body onload="document.getElementById('ssoForm').submit();">
    <h2>Securely logging you in to your hosting account...</h2>
    <div class="loader"></div>
    <form id="ssoForm" action="<?php echo htmlspecialchars($actionUrl); ?>" method="POST" style="display: none;">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
        <input type="hidden" name="languageSelection" value="english">
    </form>
</body>
</html>