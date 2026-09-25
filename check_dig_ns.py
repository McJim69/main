import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check NS records for victoryfreewifi.net using Google DNS
stdin, stdout, stderr = ssh.exec_command('dig @8.8.8.8 NS victoryfreewifi.net')
sys.stdout.buffer.write(stdout.read())

ssh.close()
