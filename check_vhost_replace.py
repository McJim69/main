import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check occurrences of virtualHostUser:nobody
stdin, stdout, stderr = ssh.exec_command('grep -n "virtualHostUser}:nobody" /usr/local/CyberCP/plogical/vhost.py')
sys.stdout.buffer.write(b"Matches of nobody:\n" + stdout.read())

ssh.close()
