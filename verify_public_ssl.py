import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check SSL on NPM (public IP)
stdin, stdout, stderr = ssh.exec_command('echo | openssl s_client -showcerts -servername victoryfreewifi.net -connect 180.193.203.22:443 2>/dev/null | openssl x509 -inform pem -noout -text | grep -A 5 -B 5 "Issuer:"')
sys.stdout.buffer.write(stdout.read())

ssh.close()
