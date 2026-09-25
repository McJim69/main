import paramiko

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('curl -s -H "Host: mcjim-server.com" http://127.0.0.1 | tail -n 20')
print(stdout.read().decode())
print(stderr.read().decode())
ssh.close()
