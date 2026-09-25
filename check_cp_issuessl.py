import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check cyberpanel issueSSL
stdin, stdout, stderr = ssh.exec_command('grep -A 20 -B 5 "attempting renewal" /usr/local/CyberCP/plogical/vhostUtilities.py')
sys.stdout.buffer.write(stdout.read())

ssh.close()
