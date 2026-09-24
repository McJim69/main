import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)
    stdin, stdout, stderr = client.exec_command('find / -name "CyberPanel.php" 2>/dev/null')
    out = stdout.read().decode('utf-8')
    print("Found CyberPanel.php at:")
    print(out)
except Exception as e:
    print("Error:", e)
