import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('tail -n 50 /home/cyberpanel/error-logs.txt')
out = stdout.read().decode('utf-8')
err = stderr.read().decode('utf-8')

if out:
    print("CyberPanel Error Logs:")
    print(out)
if err:
    print("Error:", err)
    
stdin, stdout, stderr = client.exec_command('cat /var/log/cyberpanel/main.log | tail -n 20')
out = stdout.read().decode('utf-8')
if out:
    print("CyberPanel Main Logs:")
    print(out)
