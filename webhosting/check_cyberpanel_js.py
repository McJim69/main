import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('grep -ri "initiateLogin" /usr/local/CyberCP/public/static/ -A 15')
out = stdout.read().decode('utf-8')
if out:
    print("Found initiateLogin:")
    print(out[:2000])
