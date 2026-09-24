import paramiko, os

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

# Find the actual JS location
stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name '*.js' | grep -i bootstrap | head -20")
print("Bootstrap JS files:", stdout.read().decode())

stdin, stdout, stderr = client.exec_command("find /usr/local/lsws/Example/html -name '*.css' | grep -i bootstrap | head -20")
print("Bootstrap CSS files:", stdout.read().decode())

client.close()
