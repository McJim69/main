import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('ls -l /usr/local/lsws/Example/html/ && cat /usr/local/lsws/Example/html/index.html | head -n 30')
print(stdout.read().decode('utf-8'))
