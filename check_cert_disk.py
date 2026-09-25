import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Check cert on disk
stdin, stdout, stderr = ssh.exec_command('openssl x509 -in /etc/letsencrypt/live/victoryfreewifi.net/cert.pem -noout -text | grep -A 5 -B 5 "Issuer:"')
sys.stdout.buffer.write(stdout.read())

ssh.close()
