import paramiko

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('cat /etc/nginx/sites-available/proxy-services | head -n 30')
print(stdout.read().decode())
print(stderr.read().decode())
ssh.close()
