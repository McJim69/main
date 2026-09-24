<?php
/**
 * CyberPanel SSO Bridge for FOSSBilling
 */

if (!isset($_GET['token'])) {
    die("Invalid or missing SSO token.");
}

$token = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['token']);
$tokenFile = __DIR__ . '/data/cache/sso_' . $token;

if (!file_exists($tokenFile)) {
    die("SSO token expired or invalid.");
}

// Retrieve credentials
$data = json_decode(file_get_contents($tokenFile), true);
$host = $data['host'];
$username = $data['username'];
$password = $data['password'];

// Invalidate token immediately for security
unlink($tokenFile);

$actionUrl = rtrim($host, '/') . '/api/loginAPI';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logging into CyberPanel...</title>
    <style>
        body {
            background-color: #0d1117;
            color: #c9d1d9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
        }
        .spinner {
            border: 4px solid rgba(255, 255, 255, 0.1);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border-left-color: #58a6ff;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h2 { font-weight: 500; font-size: 18px; }
    </style>
</head>
<body onload="document.getElementById('ssoForm').submit();">

    <div class="spinner"></div>
    <h2>Authenticating you into CyberPanel securely...</h2>
    <p id="status" style="font-size:13px;color:#8b949e;margin-top:8px;"></p>

    <form id="ssoForm" action="<?php echo htmlspecialchars($actionUrl); ?>" method="POST" style="display: none;">
        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
        <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
        <input type="hidden" name="languageSelection" value="english">
    </form>

    <script>
        // Timeout fallback: if we're still on this page after 5s, show an error
        setTimeout(function () {
            var el = document.getElementById('status');
            if (el) el.textContent = 'Redirecting to CyberPanel…';
        }, 1500);
        setTimeout(function () {
            var el = document.getElementById('status');
            if (el && document.title.includes('Logging')) {
                el.style.color = '#f85149';
                el.textContent = 'Login failed. Please try again from the client area.';
            }
        }, 5000);
    </script>
</body>
</html>
