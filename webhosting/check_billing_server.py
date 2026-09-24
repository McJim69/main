import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
try:
    client.connect('180.193.203.22', username='root', password='McJim654123', timeout=5)
    stdin, stdout, stderr = client.exec_command('ls -la /var/www/html/billing/library/Server/Manager/CyberPanel.php')
    print("OUT:", stdout.read().decode('utf-8'))
except Exception as e:
    print("Error:", e)
