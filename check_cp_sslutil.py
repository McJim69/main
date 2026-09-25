import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check sslUtilities
stdin, stdout, stderr = ssh.exec_command('sed -n "990,1020p" /usr/local/CyberCP/plogical/sslUtilities.py')
sys.stdout.buffer.write(stdout.read())

ssh.close()
