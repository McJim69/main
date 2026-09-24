import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('cat /usr/local/CyberCP/CyberCP/settings.py | grep -A 10 "DATABASES = {"')
out = stdout.read().decode('utf-8')
print(out)
