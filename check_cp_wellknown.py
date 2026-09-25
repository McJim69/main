import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check customACME.py token path
stdin, stdout, stderr = ssh.exec_command('grep -A 2 -B 2 "\.well-known" /usr/local/CyberCP/plogical/customACME.py')
sys.stdout.buffer.write(stdout.read())

ssh.close()
