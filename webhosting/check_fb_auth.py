import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.52', username='root', password='McJim654123', timeout=10)

# Check FOSSBilling Auth process
stdin, stdout, stderr = client.exec_command("cat /var/www/html/billing/modules/Client/Service.php | grep -A 20 'function login'")
print("SERVICE:\n", stdout.read().decode('utf-8'))
