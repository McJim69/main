import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("cat /var/www/html/billing/modules/Client/Api/Guest.php | grep -A 20 'public function login'")
print("API:\n", stdout.read().decode('utf-8'))
