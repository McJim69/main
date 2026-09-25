import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check ecc config
stdin, stdout, stderr = ssh.exec_command('cat /root/.acme.sh/victoryfreewifi.net_ecc/victoryfreewifi.net.conf')
sys.stdout.buffer.write(stdout.read())

ssh.close()
