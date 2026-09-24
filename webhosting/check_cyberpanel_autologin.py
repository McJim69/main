import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('grep -ri "autologin" /usr/local/CyberCP/')
out = stdout.read().decode('utf-8')
if out:
    print("Found autologin endpoints:")
    print(out[:2000])
else:
    print("No autologin found.")
