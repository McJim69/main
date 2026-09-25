import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check lsws config for victoryfreewifi.net
stdin, stdout, stderr = ssh.exec_command('grep -A 5 -i "cert" /usr/local/lsws/conf/vhosts/victoryfreewifi.net/vhost.conf')
sys.stdout.buffer.write(stdout.read())

ssh.close()
