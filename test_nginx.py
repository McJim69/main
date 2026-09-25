import paramiko
import sys

host = '10.0.10.15'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('ls -l /etc/nginx/sites-enabled/')
print("sites-enabled:")
print(stdout.read().decode())

stdin, stdout, stderr = ssh.exec_command('curl -I -H "Host: louiecaraircon.com" http://10.0.10.51')
print("curl to 10.0.10.51:")
print(stdout.read().decode())
print(stderr.read().decode())
ssh.close()
