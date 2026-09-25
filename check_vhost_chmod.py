import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check chmod in vhost.py
stdin, stdout, stderr = ssh.exec_command('grep -C 5 "chmod.*755" /usr/local/CyberCP/plogical/vhost.py')
sys.stdout.buffer.write(stdout.read())

ssh.close()
