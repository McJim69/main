import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

stdin, stdout, stderr = ssh.exec_command('systemctl status pdns --no-pager | sed "s/\\x$(printf %x 9679)//g"')
sys.stdout.buffer.write(stdout.read())
sys.stderr.buffer.write(stderr.read())

ssh.close()
