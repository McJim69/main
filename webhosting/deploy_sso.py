import paramiko
import sys

sso_code = """<?php
require_once 'load.php';
$di = include 'di.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header('Location: https://mcjim-server.com/webhosting.html?error=missing');
    exit;
}

try {
    $api_guest = $di['api_guest'];
    $result = $api_guest->client_login(['email' => $email, 'password' => $password]);
    
    header('Location: /client/me');
    exit;
} catch (Exception $e) {
    header('Location: https://mcjim-server.com/webhosting.html?error=invalid');
    exit;
}
"""

try:
    client = paramiko.SSHClient()
    client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)
    
    sftp = client.open_sftp()
    remote_path = '/var/www/html/billing/sso.php'
    
    with sftp.file(remote_path, 'w') as f:
        f.write(sso_code)
        
    sftp.chmod(remote_path, 0o644)
    print(f"Deployed sso.php to {remote_path}")
    
    sftp.close()
    client.close()
except Exception as e:
    print("Error:", e)
    sys.exit(1)
