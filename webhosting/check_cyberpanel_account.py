import paramiko

client = paramiko.SSHClient()
client.set_missing_host_key_policy(paramiko.AutoAddPolicy())
client.connect('10.0.10.51', username='root', password='McJim654123', timeout=10)

stdin, stdout, stderr = client.exec_command('ls -l /home/test-mcjim.com')
out = stdout.read().decode('utf-8')
err = stderr.read().decode('utf-8')

if out:
    print("Found test-mcjim.com:")
    print(out)
if err:
    print("Error:", err)
