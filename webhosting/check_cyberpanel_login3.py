import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('grep -ri "def loginToken" /usr/local/CyberCP/ -A 5')
out = stdout.read().decode('utf-8')
if out:
    print(out)
else:
    print("No loginToken definition found.")
    
stdin, stdout, stderr = client.exec_command('grep -ri "token" /usr/local/CyberCP/api/views.py | head -n 20')
out2 = stdout.read().decode('utf-8')
if out2:
    print(out2)
