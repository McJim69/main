import paramiko
import sys

host = '10.0.10.51'
user = 'root'
password = 'McJim654123'

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(host, username=user, password=password)

# Fix permissions for victoryfreewifi.net
stdin, stdout, stderr = ssh.exec_command('chown -R victo6157:nogroup /home/victoryfreewifi.net/public_html; chmod -R 750 /home/victoryfreewifi.net/public_html; chmod 755 /home/victoryfreewifi.net/public_html; curl -I http://127.0.0.1 -H "Host: victoryfreewifi.net"')
sys.stdout.buffer.write(stdout.read())
sys.stdout.buffer.write(stderr.read())

ssh.close()
