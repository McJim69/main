import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command("cat /usr/local/CyberCP/api/views.py | grep -A 30 'def loginAPI('")
print("OUT:", stdout.read().decode('utf-8'))
