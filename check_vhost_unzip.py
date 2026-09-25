import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check cyberpanel website creation logs or vhost.py
stdin, stdout, stderr = ssh.exec_command('cat /usr/local/CyberCP/plogical/vhost.py | grep -A 10 -B 10 unzip')
sys.stdout.buffer.write(stdout.read())

ssh.close()
