import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name 'bootstrap.min.css' 2>/dev/null")
print("CSS:", stdout.read().decode())
stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name 'bootstrap.bundle.min.js' 2>/dev/null")
print("JS:", stdout.read().decode())

client.close()
