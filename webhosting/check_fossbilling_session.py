import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("cat /var/www/html/billing/config.php | grep -i session -A 5")
print("OUT:", stdout.read().decode('utf-8'))
