import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check CyberPanel SSL
stdin, stdout, stderr = ssh.exec_command('echo | openssl s_client -showcerts -servername victoryfreewifi.net -connect 10.0.10.51:443 2>/dev/null | openssl x509 -inform pem -noout -text')
sys.stdout.buffer.write(stdout.read())

ssh.close()
