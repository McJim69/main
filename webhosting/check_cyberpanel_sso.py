import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('grep -ri "createLoginToken" /usr/local/CyberCP/api/')
out = stdout.read().decode('utf-8')
if out:
    print("Found token endpoints:")
    print(out)
else:
    print("No createLoginToken found.")
    
# Let's also grep for "loginToken"
stdin, stdout, stderr = client.exec_command('grep -ri "loginToken" /usr/local/CyberCP/api/')
out2 = stdout.read().decode('utf-8')
if out2:
    print("Found loginToken endpoints:")
    print(out2)
